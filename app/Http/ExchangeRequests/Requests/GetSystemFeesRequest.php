<?php

namespace App\Http\ExchangeRequests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSystemFeesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
