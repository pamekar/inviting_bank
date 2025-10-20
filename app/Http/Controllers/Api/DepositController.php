<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'source' => 'required|string|in:mobile_money,bank_transfer,salary,cash',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::where('user_id', auth()->id())->findOrFail($request->account_id);

        $transaction = Transaction::create([
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        $deposit = Deposit::create([
            'transaction_id' => $transaction->id,
            'source' => $request->source,
        ]);

        return response()->json($deposit, 201);
    }

    public function index()
    {
        return Deposit::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function show($id)
    {
        return Deposit::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    public function confirm($id)
    {
        $deposit = Deposit::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        if ($deposit->transaction->status !== 'pending') {
            return response()->json(['message' => 'Only pending deposits can be confirmed'], 400);
        }

        $deposit->transaction->update(['status' => 'completed']);
        $deposit->transaction->account->increment('balance', $deposit->transaction->amount);

        return response()->json($deposit);
    }
}