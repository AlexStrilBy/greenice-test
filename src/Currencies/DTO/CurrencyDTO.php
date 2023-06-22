<?php

namespace Src\Currencies\DTO;

use App\Models\Currency;

class CurrencyDTO
{
    public function __construct(
        public int $id,
        public string $code,
        public string $symbol,
    )
    {
    }

    public static function fromModel(Currency $currency): CurrencyDTO
    {
        return new self($currency->id, $currency->code, $currency->symbol);
    }
}
