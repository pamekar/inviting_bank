<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PendingAuthorizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $details = json_decode($this->transaction_details);
        $description = 'A ' . str_replace('_', ' ', $this->authorization_type) . ' has been initiated and is awaiting authorization.';

        if ($this->authorization_type === 'transfer') {
            $description .= ' Source Account: ' . $details->source_account_id . ', Destination Account: ' . $details->destination_account_id . ', Amount: ' . $details->transaction->amount;
        } elseif ($this->authorization_type === 'bill_payment') {
            $description .= ' Biller: ' . $details->biller . ', Customer Reference: ' . $details->customer_reference . ', Amount: ' . $details->transaction->amount;
        }

        return [
            'id' => $this->id,
            'authorization_type' => $this->authorization_type,
            'transaction_details' => $details,
            'expires_at' => $this->expires_at,
            'status' => $this->status,
            'description' => $description,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        $details = json_decode($this->transaction_details);
        $chat_message = "A *{$this->authorization_type}* request has been initiated and requires your approval.\n\n";

        if ($this->authorization_type === 'transfer') {
            $chat_message .= "*Source Account:* {$details->source_account_id}\n*Destination Account:* {$details->destination_account_id}\n*Amount:* *{$details->transaction->amount} NGN*";
        } elseif ($this->authorization_type === 'bill_payment') {
            $chat_message .= "*Biller:* {$details->biller}\n*Customer Reference:* {$details->customer_reference}\n*Amount:* *{$details->transaction->amount} NGN*";
        }

        $chat_message .= "\n\n_This request will expire at {$this->expires_at}._";

        return [
            'chat_message' => $chat_message,
        ];
    }
}