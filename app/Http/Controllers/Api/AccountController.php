<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountTier;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        return Account::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_tier_id' => 'required|exists:account_tiers,id',
            'type' => 'required|string|in:savings,checking,investment',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::create([
            'user_id' => auth()->id(),
            'account_tier_id' => $request->account_tier_id,
            'type' => $request->type,
            'account_number' => rand(1000000000, 9999999999),
        ]);

        return response()->json($account, 201);
    }

    public function show($id)
    {
        return Account::where('user_id', auth()->id())->findOrFail($id);
    }

    public function balance($id)
    {
        $account = Account::where('user_id', auth()->id())->findOrFail($id);
        return response()->json(['balance' => $account->balance]);
    }

    public function statements($id)
    {
        $account = Account::where('user_id', auth()->id())->findOrFail($id);
        return $account->transactions;
    }

    public function update(Request $request, $id)
    {
        $account = Account::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'string|in:active,suspended,closed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account->update($request->all());

        return response()->json($account);
    }
}