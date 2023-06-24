<?php

namespace Src\ExchangeRequests\Events;

use App\Models\ExchangeRequest;
use App\Models\UserWallet;
use Illuminate\Foundation\Events\Dispatchable;

class ExchangeRequestAppliedEvent
{
    use Dispatchable;

    public function __construct(
        public ExchangeRequest $exchangeRequest,
        public UserWallet $walletFrom,
        public UserWallet $walletTo,
    )
    {
    }
}
