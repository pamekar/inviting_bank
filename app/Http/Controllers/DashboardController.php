<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function transfers()
    {
        return view('transfers');
    }

    public function billPayments()
    {
        return view('bill-payments');
    }

    public function transactions()
    {
        return view('transactions');
    }

    public function accounts()
    {
        return view('accounts');
    }

    public function statistics()
    {
        return view('statistics');
    }
}
