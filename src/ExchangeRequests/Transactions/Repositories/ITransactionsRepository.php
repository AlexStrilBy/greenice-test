<?php

namespace Src\ExchangeRequests\Transactions\Repositories;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ITransactionsRepository
{
    /**
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return Collection<Transaction>
     */
    public function getTransactionsByDates(Carbon $dateFrom, Carbon $dateTo): Collection;
}
