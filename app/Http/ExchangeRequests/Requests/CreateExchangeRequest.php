<?php

namespace App\Http\ExchangeRequests\Requests;

use App\Models\UserWallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateExchangeRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = auth()->user()->id;

        return [
            'from_currency_id' => [
                'required',
                'int',
            ],
            'to_currency_id' => [
                'required',
                'int',
            ],
            'amount_from' => ['required', 'numeric'],
            'amount_to' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
