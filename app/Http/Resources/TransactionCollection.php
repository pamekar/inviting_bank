<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'status' => $transaction->status,
                'created_at' => $transaction->created_at,
            ];
        });
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        $chat_message = "Here is a summary of your recent transactions:\n\n";

        $this->collection->each(function ($transaction) use (&$chat_message) {
            $type = ucfirst($transaction->type);
            $amount = number_format($transaction->amount, 2);
            $status = $transaction->status;
            $date = $transaction->created_at->format('M d, Y');
            $chat_message .= "*- {$type}* of *₦{$amount}* (_{$status}_) on {$date}\n";
        });

        return [
            'chat_message' => $chat_message,
        ];
    }
}
