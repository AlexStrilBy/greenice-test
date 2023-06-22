<?php

namespace Src\ExchangeRequests\Resources;

use App\Models\ExchangeRequest;
use DB;
use Exception;
use Src\ExchangeRequests\DTO\CreateExchangeRequestDTO;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;
use Src\Users\Repositories\UserInfoRepository;

class ExchangeRequestsService
{
    public function __construct(
        private readonly UserInfoRepository $userInfoRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(CreateExchangeRequestDTO $request): ExchangeRequest
    {
        // region perform validation
        $user = $this->userInfoRepository->getUserInfoWithWallets($request->userId);

        $walletFrom = $user->wallets->where('currency_id', $request->fromCurrency)->first();
        $walletTo = $user->wallets->where('currency_id', $request->toCurrency)->first();

        if (!isset($walletFrom) || !isset($walletTo)) {
            throw new Exception('You don\'t have this currencies in your wallets');
        }

        if ($walletFrom->balance < $request->amountFrom) {
            throw new Exception('Your balance is not enough to perform this exchange');
        }
        // endregion

        // region create exchange request
        return DB::transaction(function () use ($request, $walletFrom, $walletTo) {
            $walletFrom->balance -= $request->amountFrom;
            $walletFrom->save();

            $exchangeRequest = new ExchangeRequest();

            $exchangeRequest->from_user_id = $request->userId;
            $exchangeRequest->from_currency_id = $request->fromCurrency;
            $exchangeRequest->to_currency_id = $request->toCurrency;
            $exchangeRequest->from_amount = $request->amountFrom;
            $exchangeRequest->to_amount = $request->amountTo;
            $exchangeRequest->status = ExchangeRequestStatuses::PENDING;

            $exchangeRequest->save();

            $exchangeRequest->setRelations([
                'fromCurrency' => $walletFrom->currency,
                'toCurrency' => $walletTo->currency,
            ]);

            return $exchangeRequest;
        });
        // endregion
    }
}
