<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\AccountBalanceResource;
use App\Http\Resources\TransactionResource;
use App\Models\User;

use App\Http\Requests\WhatsAppBillPaymentRequest;
use App\Http\Requests\WhatsAppTransferRequest;
use App\Http\Resources\BillPaymentResource;
use App\Http\Resources\PendingAuthorizationResource;
use App\Models\Account;
use App\Models\PendingAuthorization;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\UtilityPayment;

class WhatsAppAPIController extends Controller
{
    public function getBalance(Request $request)
    {
        Log::info('WhatsApp API: getBalance request received', ['request' => $request->all()]);
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();

        Log::info(json_encode($user));
        if (!$user) {
            return response()->json([
                'error' => 'UserNotFound',
                'message' => 'A user with the provided phone number could not be found.',
                'context' => [
                    'phone_number' => $request->phone_number
                ]
            ], 404);
        }

        $account = $user->accounts()->first();

        return new AccountBalanceResource($account);
    }

    public function getTransactionHistory(Request $request)
    {
        Log::info('WhatsApp API: getTransactionHistory request received', ['request' => $request->all()]);
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'error' => 'UserNotFound',
                'message' => 'A user with the provided phone number could not be found.',
                'context' => [
                    'phone_number' => $request->phone_number
                ]
            ], 404);
        }

        $account = $user->accounts()->first();
        $limit = $request->input('limit', 10);

        $transactions = $account->transactions()->latest()->take($limit)->get();

        return TransactionResource::collection($transactions);
    }

    public function transfer(WhatsAppTransferRequest $request)
    {
        Log::info('WhatsApp API: transfer request received', ['request' => $request->all()]);
        $sourceUser = User::where('phone_number', $request->source_phone_number)->first();

        if (!$sourceUser) {
            return response()->json([
                'error' => 'UserNotFound',
                'message' => 'A user with the provided source phone number could not be found.',
                'context' => [
                    'phone_number' => $request->source_phone_number
                ]
            ], 404);
        }

        $sourceAccount = $sourceUser->accounts()->first();
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
            'user_id' => $sourceUser->id,
            'authorization_type' => 'transfer',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($transfer),
            'expires_at' => now()->addMinutes(15),
        ]);

        return new PendingAuthorizationResource($authorization);
    }

    public function billPayment(WhatsAppBillPaymentRequest $request)
    {
        Log::info('WhatsApp API: billPayment request received', ['request' => $request->all()]);
        $sourceUser = User::where('phone_number', $request->source_phone_number)->first();

        if (!$sourceUser) {
            return response()->json([
                'error' => 'UserNotFound',
                'message' => 'A user with the provided source phone number could not be found.',
                'context' => [
                    'phone_number' => $request->source_phone_number
                ]
            ], 404);
        }

        $sourceAccount = $sourceUser->accounts()->first();

        if ($sourceAccount->balance < $request->amount) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        $transaction = Transaction::create([
            'account_id' => $sourceAccount->id,
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
            'user_id' => $sourceUser->id,
            'authorization_type' => 'bill_payment',
            'transaction_id' => $transaction->id,
            'transaction_details' => json_encode($billPayment),
            'expires_at' => now()->addMinutes(15),
        ]);

        return new BillPaymentResource($authorization);
    }
}
