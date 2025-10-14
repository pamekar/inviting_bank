<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TwoFactorAuth;
use App\Models\TotpSecret;
use App\Models\PendingAuthorization;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TwoFactorAuthController extends Controller
{
    public function setup(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();

        $totpSecret = TotpSecret::create([
            'user_id' => $user->id,
            'secret' => $google2fa->generateSecretKey(),
        ]);

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'Nigerian Bank',
            $user->email,
            $totpSecret->secret
        );

        return view('2fa.setup', [
            'qr_code_url' => $qrCodeUrl,
            'secret' => $totpSecret->secret,
        ]);
    }

    public function verifySetup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();
        $google2fa = new Google2FA();

        $totpSecret = TotpSecret::where('user_id', $user->id)->where('secret', $request->secret)->firstOrFail();

        if ($google2fa->verifyKey($totpSecret->secret, $request->code)) {
            $totpSecret->update(['verified_at' => now()]);
            TwoFactorAuth::updateOrCreate(['user_id' => $user->id], ['is_enabled' => true]);
            return redirect()->route('profile')->with('status', '2fa-enabled');
        }

        return redirect()->back()->withErrors(['code' => 'Invalid code']);
    }

    public function disable(Request $request)
    {
        $user = auth()->user();
        TwoFactorAuth::where('user_id', $user->id)->update(['is_enabled' => false]);
        return redirect()->route('profile')->with('status', '2fa-disabled');
    }

    public function backupCodes(Request $request)
    {
        $user = auth()->user();
        $totpSecret = TotpSecret::where('user_id', $user->id)->where('verified_at', '!=', null)->firstOrFail();

        $backupCodes = Collection::times(8, function () {
            return rand(100000, 999999);
        });

        $totpSecret->update(['backup_codes' => $backupCodes->map(function ($code) {
            return bcrypt($code);
        })]);

        return response()->json($backupCodes);
    }

    public function status(Request $request)
    {
        $user = auth()->user();
        $twoFactorAuth = TwoFactorAuth::where('user_id', $user->id)->first();
        return response()->json(['is_enabled' => $twoFactorAuth ? $twoFactorAuth->is_enabled : false]);
    }

    public function sendSmsOtp(Request $request)
    {
        //
    }

    public function verifyOtp(Request $request)
    {
        //
    }

    public function pendingAuthorizations(Request $request)
    {
        return PendingAuthorization::where('user_id', auth()->id())->where('status', 'awaiting_verification')->get();
    }

    public function approveAuthorization(Request $request, $id)
    {
        $authorization = PendingAuthorization::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();
        $google2fa = new Google2FA();
        $totpSecret = TotpSecret::where('user_id', $user->id)->where('verified_at', '!=', null)->firstOrFail();

        $valid = $google2fa->verifyKey($totpSecret->secret, $request->code);

        if (!$valid) {
            foreach ($totpSecret->backup_codes as $backupCode) {
                if (Hash::check($request->code, $backupCode)) {
                    $valid = true;
                }
            }
        }

        if ($valid) {
            $authorization->update(['status' => 'approved', 'approved_at' => now()]);

            $transaction = Transaction::findOrFail($authorization->transaction_id);
            $account = Account::findOrFail($transaction->account_id);
            $fee = 0;

            if ($transaction->type === 'transfer') {
                $transfer = Transfer::where('transaction_id', $transaction->id)->firstOrFail();
                $sourceAccount = Account::findOrFail($transfer->source_account_id);
                $destinationAccount = Account::findOrFail($transfer->destination_account_id);
                $fee = TransactionFee::where('type', 'transfer')->where('min_amount', '<=', $transaction->amount)->where('max_amount', '>=', $transaction->amount)->first()->fee ?? 0;

                $sourceAccount->decrement('balance', $transaction->amount + $fee);
                $destinationAccount->increment('balance', $transaction->amount);
            } elseif ($transaction->type === 'withdrawal') {
                $fee = TransactionFee::where('type', 'withdrawal')->first()->fee ?? 0;
                $account->decrement('balance', $transaction->amount + $fee);
            } elseif ($transaction->type === 'bill_payment') {
                $account->decrement('balance', $transaction->amount);
            }

            $transaction->update(['status' => 'completed']);

            return response()->json(['message' => 'Authorization approved']);
        }

        return response()->json(['message' => 'Invalid code'], 400);
    }

    public function rejectAuthorization(Request $request, $id)
    {
        $authorization = PendingAuthorization::where('user_id', auth()->id())->findOrFail($id);
        $authorization->update(['status' => 'rejected']);
        return response()->json(['message' => 'Authorization rejected']);
    }

    public function verifyTotp(Request $request, $id)
    {
        //
    }

    public function verifySmsOtp(Request $request, $id)
    {
        //
    }

    public function addTrustedDevice(Request $request)
    {
        //
    }

    public function trustedDevices(Request $request)
    {
        //
    }

    public function removeTrustedDevice(Request $request, $id)
    {
        //
    }

    public function forgetDevice(Request $request, $id)
    {
        //
    }

    public function enable2fa(Request $request)
    {
        //
    }

    public function disable2fa(Request $request)
    {
        //
    }
}