<?php

namespace Src\ExchangeRequests\Repositories;

use App\Models\ExchangeRequest;
use Illuminate\Support\Collection;

interface IExchangeRequestsRepository
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection<ExchangeRequest>
     */
    public function getAllUserRequests(int $userId): Collection;

    /**
     * @return Collection<ExchangeRequest>
     */
    public function getAllAvailableRequests(): Collection;

    /**
     * @param int $id
     * @param int $userId
     * @return ExchangeRequest|null
     */
    public function findByIdAndUserId(int $id, int $userId): ?ExchangeRequest;
}
