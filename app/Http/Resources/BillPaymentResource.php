<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillPaymentResource extends JsonResource
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
        $description .= ' Biller: ' . $details->biller . ', Customer Reference: ' . $details->customer_reference . ', Amount: ' . $details->transaction->amount;

        $chat_message = "A *bill payment* request has been initiated and requires your approval.\n\n";
        $chat_message .= "*Biller:* {$details->biller}\n*Customer Reference:* {$details->customer_reference}\n*Amount:* *{$details->transaction->amount} USD*";
        $chat_message .= "\n\n_This request will expire at {$this->expires_at}._";

        return [
            'id' => $this->id,
            'authorization_type' => $this->authorization_type,
            'transaction_details' => $details,
            'expires_at' => $this->expires_at,
            'status' => $this->status,
            'description' => $description,
            'chat_message' => $chat_message,
        ];
    }
}