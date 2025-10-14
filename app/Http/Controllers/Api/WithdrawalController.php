<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\PendingAuthorization;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string|in:atm,otc',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::where('user_id', auth()->id())->findOrFail($request->account_id);

        if ($account->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $transaction = Transaction::create([
            'account_id' => $account->id,
            'type' => 'withdrawal',
            'amount' => $request->amount,
            'status' => 'awaiting_authorization',
        ]);

        $withdrawal = Withdrawal::create([
            'transaction_id' => $transaction->id,
            'type' => $request->type,
        ]);

        $authorization = PendingAuthorization::create([
            'user_id' => auth()->id(),
            'authorization_type' => 'withdrawal',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($withdrawal),
            'expires_at' => now()->addMinutes(15),
        ]);

        return response()->json($authorization, 201);
    }

    public function index()
    {
        return Withdrawal::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function show($id)
    {
        return Withdrawal::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    public function cancel($id)
    {
        $withdrawal = Withdrawal::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        if ($withdrawal->transaction->status !== 'pending') {
            return response()->json(['message' => 'Only pending withdrawals can be cancelled'], 400);
        }

        $withdrawal->transaction->update(['status' => 'cancelled']);

        return response()->json($withdrawal);
    }
}
