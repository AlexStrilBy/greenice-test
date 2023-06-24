<?php

namespace App\Http\ExchangeRequests\Controllers;

use App\Http\Controllers\Controller;
use App\Http\ExchangeRequests\Requests\GetSystemFeesRequest;
use App\Models\Transaction;
use App\Services\ApiAnswerService;
use Carbon\Carbon;
use Exception;
use Src\ExchangeRequests\Transactions\DTO\SystemFeeDTO;
use Src\ExchangeRequests\Transactions\Repositories\ITransactionsRepository;

class TransactionsController extends Controller
{
    public function __construct(
        private ITransactionsRepository $transactionsRepository,
    )
    {
    }

    public function systemFeeIndex(GetSystemFeesRequest $request)
    {
        try {
            $transactions = $this->transactionsRepository->getTransactionsByDates(
                Carbon::parse($request->input('date_from')),
                Carbon::parse($request->input('date_to')),
            );

            return ApiAnswerService::successMessage(
                $transactions->map(function (Transaction $transaction) {
                    return SystemFeeDTO::fromModel($transaction);
                })->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }
}
