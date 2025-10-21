<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'account_holder_name' => $this->user->name,
            'account_number' => $this->account_number,
            'account_type' => $this->type,
            'balance' => $this->balance,
            'currency' => 'USD', // Assuming USD for now, you can make this dynamic
            'description' => 'The current balance for the specified account.',
            'chat_message' => "Hello *{$this->user->name}*!\n\nYour account balance is:\n\n*Account Number:* {$this->account_number}\n*Balance:* *{$this->balance} USD*",
        ];
    }
}