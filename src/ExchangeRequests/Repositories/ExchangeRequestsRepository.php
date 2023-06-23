<?php

namespace Src\ExchangeRequests\Repositories;

use App\Models\ExchangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;

class ExchangeRequestsRepository implements IExchangeRequestsRepository
{

    /**
     * @inheritDoc
     */
    public function getAllUserRequests(int $userId): Collection
    {
        return ExchangeRequest::query()
            ->where('user_id', $userId)
            ->with('fromCurrency', 'toCurrency')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getAllAvailableRequests(): Collection
    {
        return ExchangeRequest::query()
            ->where('status', ExchangeRequestStatuses::PENDING)
            ->with('fromCurrency', 'toCurrency')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function findByIdAndUserId(int $id, int $userId): ?ExchangeRequest
    {
        return ExchangeRequest::query()
            ->where('id', $id)
            ->where('from_user_id', $userId)
            ->first();
    }
}
