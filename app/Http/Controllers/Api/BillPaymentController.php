<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BillPaymentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UtilityPayment;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\PendingAuthorization;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\BillPaymentRequest;

class BillPaymentController extends Controller
{
    public function pay(BillPaymentRequest $request)
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

    public function index()
    {
        return UtilityPayment::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function show($id)
    {
        return UtilityPayment::whereHas('transaction.account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    public function providers()
    {
        return response()->json([
            'NEPA',
            'LagosWater',
            'MTN',
            'Airtel',
        ]);
    }

    public function schedule(Request $request)
    {
        //
    }

    public function savedBillers()
    {
        //
    }

    public function addBiller(Request $request)
    {
        //
    }
}
