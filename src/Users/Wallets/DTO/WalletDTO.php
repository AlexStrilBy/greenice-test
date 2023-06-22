<?php

namespace Src\Users\Wallets\DTO;

use App\Models\UserWallet;
use Spatie\LaravelData\Data;
use Src\Currencies\DTO\CurrencyDTO;

class WalletDTO extends Data
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $currencyId,
        public float $balance,
        public CurrencyDTO $currency,
    )
    {
    }

    public static function fromModel(UserWallet $wallet): WalletDTO
    {
        return new self(
            $wallet->id,
            $wallet->user_id,
            $wallet->currency_id,
            $wallet->balance,
            CurrencyDTO::fromModel($wallet->currency)
        );
    }
}
