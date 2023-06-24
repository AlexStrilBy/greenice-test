<?php

namespace Src\ExchangeRequests\Resources;

use App\Models\ExchangeRequest;

class CommissionService
{
    private float $systemFee;
    public static self $instance;

    public function __construct()
    {
        $this->systemFee = config('commission.system_fee');
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getSystemFee()
    {
        return $this->systemFee;
    }
}
