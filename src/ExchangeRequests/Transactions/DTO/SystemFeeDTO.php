<?php

namespace Src\ExchangeRequests\Transactions\DTO;

use App\Models\Transaction;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class SystemFeeDTO extends Data
{
    public function __construct(
        public string $currency,
        public float  $amount,
        public Carbon $date,
    )
    {
    }

    public static function fromModel(Transaction $transaction): self
    {
        return new self(
            $transaction->systemFeeCurrency->code,
            $transaction->system_fee,
            $transaction->created_at
        );
    }
}
