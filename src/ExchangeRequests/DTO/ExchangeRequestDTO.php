<?php

namespace Src\ExchangeRequests\DTO;

use App\Models\ExchangeRequest;
use Spatie\LaravelData\Data;
use Src\Currencies\DTO\CurrencyDTO;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;

class ExchangeRequestDTO extends Data
{
    public function __construct(
        public int $id,
        public int $fromUserId,
        public CurrencyDTO $fromCurrency,
        public CurrencyDTO $toCurrency,
        public float $amountFrom,
        public float $amountTo,
        public ExchangeRequestStatuses $status,
        public string $createdAt,
    )
    {
    }

    public static function fromModel(ExchangeRequest $exchangeRequest): ExchangeRequestDTO
    {
        return new self(
            $exchangeRequest->id,
            $exchangeRequest->from_user_id,
            CurrencyDTO::fromModel($exchangeRequest->fromCurrency),
            CurrencyDTO::fromModel($exchangeRequest->toCurrency),
            $exchangeRequest->from_amount,
            $exchangeRequest->to_amount,
            $exchangeRequest->status,
            $exchangeRequest->created_at
        );
    }
}
