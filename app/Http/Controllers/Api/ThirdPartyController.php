<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillPaymentRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\AccountBalanceResource;
use App\Http\Resources\BillPaymentResource;
use App\Http\Resources\PendingAuthorizationResource;
use App\Models\Account;
use App\Models\PendingAuthorization;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\UtilityPayment;

class ThirdPartyController extends Controller
{
    public function transfer(TransferRequest $request)
    {
        $sourceAccount = Account::where('user_id', auth()->id())->findOrFail($request->source_account_id);
        $destinationAccount = Account::where('account_number', $request->destination_account_number)->firstOrFail();

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
            'destination_account_id' => $destinationAccount->id,
        ]);

        $authorization = PendingAuthorization::create([
            'user_id' => auth()->id(),
            'authorization_type' => 'transfer',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($transfer),
            'expires_at' => now()->addMinutes(15),
        ]);

        return new PendingAuthorizationResource($authorization);
    }

    public function balance($accountId)
    {
        $account = Account::where('user_id', auth()->id())->findOrFail($accountId);
        return new AccountBalanceResource($account);
    }

    public function billPayment(BillPaymentRequest $request)
    {
        $account = Account::where('user_id', auth()->id())->findOrFail($request->account_id);

        if ($account->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $transaction = Transaction::create([
            'account_id' => $account->id,
            'type' => 'bill_payment',
            'amount' => $request->amount,
            'status' => 'awaiting_authorization',
        ]);

        $billPayment = UtilityPayment::create([
            'transaction_id' => $transaction->id,
            'biller' => $request->biller,
            'customer_reference' => $request->customer_reference,
        ]);

        $authorization = PendingAuthorization::create([
            'user_id' => auth()->id(),
            'authorization_type' => 'bill_payment',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($billPayment),
            'expires_at' => now()->addMinutes(15),
        ]);

        return new BillPaymentResource($authorization);
    }
}