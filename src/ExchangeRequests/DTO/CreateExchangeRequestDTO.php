<?php

namespace Src\ExchangeRequests\DTO;

use App\Http\ExchangeRequests\Requests\CreateExchangeRequest;
use Spatie\LaravelData\Data;

class CreateExchangeRequestDTO extends Data
{
    public function __construct(
        public int   $userId,
        public int   $fromCurrency,
        public int   $toCurrency,
        public float $amountFrom,
        public float $amountTo,
    )
    {
    }

    public static function fromRequest(CreateExchangeRequest $request, int $userId): self
    {
        return new self(
            $userId,
            $request->input('from_currency_id'),
            $request->input('to_currency_id'),
            $request->input('amount_from'),
            $request->input('amount_to'),
        );
    }
}
