<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transfer;
use App\Models\Account;

class ProcessScheduledTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfers:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled transfers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transfers = Transfer::where('scheduled_at', '<=', now())->whereHas('transaction', function ($query) {
            $query->where('status', 'scheduled');
        })->get();

        foreach ($transfers as $transfer) {
            $sourceAccount = Account::findOrFail($transfer->source_account_id);
            $destinationAccount = Account::findOrFail($transfer->destination_account_id);

            if ($sourceAccount->balance >= $transfer->transaction->amount) {
                $sourceAccount->decrement('balance', $transfer->transaction->amount);
                $destinationAccount->increment('balance', $transfer->transaction->amount);
                $transfer->transaction->update(['status' => 'completed']);
            } else {
                $transfer->transaction->update(['status' => 'failed']);
            }
        }
    }
}