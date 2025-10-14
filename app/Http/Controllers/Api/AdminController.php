<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function reports(Request $request)
    {
        $transactions = Transaction::query()
            ->when($request->has('start_date'), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->start_date);
            })
            ->when($request->has('end_date'), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->end_date);
            })
            ->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['ID', 'Account ID', 'Type', 'Amount', 'Status', 'Date']);

        foreach ($transactions as $transaction) {
            $csv->insertOne([
                $transaction->id,
                $transaction->account_id,
                $transaction->type,
                $transaction->amount,
                $transaction->status,
                $transaction->created_at,
            ]);
        }

        $csv->output('report.csv');

        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report.csv"',
        ]);
    }
}