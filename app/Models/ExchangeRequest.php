<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\ExchangeRequests\Resources\CommissionService;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;

class ExchangeRequest extends Model
{
    protected $casts = [
        'status' => ExchangeRequestStatuses::class,
        'system_fee' => 'float',
        'system_fee_amount' => 'float',
        'to_amount_with_fee' => 'float',
    ];

    protected $with = [
        'fromCurrency',
        'toCurrency',
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function fromCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'from_currency_id', 'id');
    }

    public function toCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'to_currency_id', 'id');
    }

    public function getSystemFeeAttribute(): float
    {
        return CommissionService::getInstance()->getSystemFee();
    }

    public function getSystemFeeAmountAttribute(): float
    {
        return $this->to_amount * $this->system_fee;
    }

    public function getToAmountWithFeeAttribute(): float
    {
        return $this->to_amount + $this->system_fee_amount;
    }
}
