<?php

namespace Src\ExchangeRequests\Listeners;

use App\Models\Transaction;
use Src\ExchangeRequests\Events\ExchangeRequestAppliedEvent;
use Src\ExchangeRequests\Transactions\Resources\TransactionService;

class ExchangeAppliedListener
{
    public function __construct(
        private readonly TransactionService $transactionService
    )
    {
    }

    public function handle(ExchangeRequestAppliedEvent $event): void
    {

        $this->transactionService->createTransaction(
            $event->exchangeRequest,
            $event->walletFrom,
            $event->walletTo
        );
    }
}
