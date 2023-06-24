<?php

namespace Src\ExchangeRequests\Transactions\Repositories;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransactionsRepository implements ITransactionsRepository
{

    public function getTransactionsByDates(Carbon $dateFrom, Carbon $dateTo): Collection
    {
        return Transaction::query()
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->with('systemFeeCurrency')
            ->get();
    }
}
