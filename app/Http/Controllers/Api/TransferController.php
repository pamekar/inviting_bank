<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Beneficiary;
use App\Models\PendingAuthorization;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_account_id'' => 'required|exists:accounts,id',
            'destination_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sourceAccount = Account::where('user_id', auth()->id())->findOrFail($request->source_account_id);

        if ($sourceAccount->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $transaction = Transaction::create([
            'account_id' => $sourceAccount->id,
            'type' => 'transfer',
            'amount' => $request->amount,
            'status' => 'awaiting_authorization',
        ]);

        $transfer = Transfer::create([
            'transaction_id' => $transaction->id,
            'source_account_id' => $sourceAccount->id,
            'destination_account_id' => $request->destination_account_id,
        ]);

        $authorization = PendingAuthorization::create([
            'user_id' => auth()->id(),
            'authorization_type' => 'transfer',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($transfer),
            'expires_at' => now()->addMinutes(15),
        ]);

        return response()->json($authorization, 201);
    }

    public function index()
    {
        return Transfer::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function show($id)
    {
        return Transfer::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    public function cancel($id)
    {
        $transfer = Transfer::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        if ($transfer->transaction->status !== 'pending') {
            return response()->json(['message' => 'Only pending transfers can be cancelled'], 400);
        }

        $transfer->transaction->update(['status' => 'cancelled']);

        return response()->json($transfer);
    }

    public function schedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_account_id' => 'required|exists:accounts,id',
            'destination_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'scheduled_at' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sourceAccount = Account::where('user_id', auth()->id())->findOrFail($request->source_account_id);

        if ($sourceAccount->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $transaction = Transaction::create([
            'account_id' => $sourceAccount->id,
            'type' => 'transfer',
            'amount' => $request->amount,
            'status' => 'scheduled',
        ]);

        $transfer = Transfer::create([
            'transaction_id' => $transaction->id,
            'source_account_id' => $sourceAccount->id,
            'destination_account_id' => $request->destination_account_id,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response()->json($transfer, 201);
    }

    public function getBeneficiaries()
    {
        return Beneficiary::where('user_id', auth()->id())->get();
    }

    public function addBeneficiary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'beneficiary_account_id' => 'required|exists:accounts,id',
            'nickname' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $beneficiary = Beneficiary::create([
            'user_id' => auth()->id(),
            'beneficiary_account_id' => $request->beneficiary_account_id,
            'nickname' => $request->nickname,
        ]);

        return response()->json($beneficiary, 201);
    }

    public function removeBeneficiary($id)
    {
        $beneficiary = Beneficiary::where('user_id', auth()->id())->findOrFail($id);
        $beneficiary->delete();

        return response()->json(null, 204);
    }
}
