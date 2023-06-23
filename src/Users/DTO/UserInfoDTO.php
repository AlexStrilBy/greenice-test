<?php

namespace Src\Users\DTO;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Src\Users\Wallets\DTO\WalletDTO;

class UserInfoDTO extends Data
{
    public function __construct(
        public UserDTO $user,
        #[DataCollectionOf(WalletDTO::class)]
        public DataCollection $wallets,
        #[DataCollectionOf(WalletDTO::class)]
        public DataCollection $exchangeRequests,
    )
    {
    }
}
