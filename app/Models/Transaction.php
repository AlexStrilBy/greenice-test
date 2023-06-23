<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'system_fee',
        'system_fee_currency_id'
    ];

    public function fromWallet(): BelongsTo
    {
        return $this->belongsTo(UserWallet::class, 'from_wallet_id', 'id');
    }

    public function toWallet(): BelongsTo
    {
        return $this->belongsTo(UserWallet::class, 'to_wallet_id', 'id');
    }

    public function systemFeeCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'system_fee_currency_id', 'id');
    }
}
