<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'biller' => 'required|string',
            'customer_reference' => 'required|string',
        ];
    }
}