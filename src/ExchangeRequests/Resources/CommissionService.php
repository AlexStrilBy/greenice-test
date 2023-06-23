<?php

namespace Src\ExchangeRequests\Resources;

use App\Models\ExchangeRequest;

class CommissionService
{
    private float $systemFee;

    public function __construct()
    {
        $this->systemFee = config('commission.system_fee');
    }

    public function getSystemFee()
    {
        return $this->systemFee;
    }

    public function addCommissionToExchangeRequest(ExchangeRequest $exchangeRequest, int $userId): ExchangeRequest
    {
        if ($exchangeRequest->from_user_id !== $userId) {
            $exchangeRequest->to_amount = $exchangeRequest->to_amount - $this->systemFee;
        }

        return $exchangeRequest;
    }
}
