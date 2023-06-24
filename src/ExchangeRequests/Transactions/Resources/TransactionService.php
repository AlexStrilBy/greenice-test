<?php

namespace Src\ExchangeRequests\Transactions\Resources;

use App\Models\ExchangeRequest;
use App\Models\Transaction;
use App\Models\UserWallet;
use DB;

class TransactionService
{
    public function createTransaction(
        ExchangeRequest $exchangeRequest,
        UserWallet      $walletFrom,
        UserWallet      $walletTo
    )
    {
        return DB::transaction(function () use ($exchangeRequest, $walletFrom, $walletTo) {
            $transaction = new Transaction();

            $transaction->exchange_request_id = $exchangeRequest->id;
            $transaction->from_wallet_id = $walletFrom->id;
            $transaction->to_wallet_id = $walletTo->id;
            $transaction->from_amount = $exchangeRequest->from_amount;
            $transaction->to_amount = $exchangeRequest->to_amount;
            $transaction->system_fee = $exchangeRequest->system_fee_amount;
            $transaction->system_fee_currency_id = $exchangeRequest->to_currency_id;

            $transaction->save();

            return $transaction;
        });
    }
}
