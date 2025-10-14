<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::whereHas('account', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function show($id)
    {
        return Transaction::whereHas('account', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
    }

    public function exportPdf()
    {
        //
    }

    public function exportCsv()
    {
        //
    }
}