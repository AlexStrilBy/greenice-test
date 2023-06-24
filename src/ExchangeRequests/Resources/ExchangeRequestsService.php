<?php

namespace Src\ExchangeRequests\Resources;

use App\Models\ExchangeRequest;
use App\Models\UserWallet;
use DB;
use Exception;
use Src\ExchangeRequests\DTO\CreateExchangeRequestDTO;
use Src\ExchangeRequests\Events\ExchangeRequestAppliedEvent;
use Src\ExchangeRequests\Repositories\IExchangeRequestsRepository;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;
use Src\Users\Repositories\IUserInfoRepository;

class ExchangeRequestsService
{
    public function __construct(
        private readonly IUserInfoRepository         $userInfoRepository,
        private readonly IExchangeRequestsRepository $exchangeRequestsRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(CreateExchangeRequestDTO $request): ExchangeRequest
    {
        return DB::transaction(function () use ($request) {
            // region perform validation
            $user = $this->userInfoRepository->getUserInfoWithWalletsAndExchangeRequests($request->userId);

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

    /**
     * @throws Exception
     */
    public function applyExchange(ExchangeRequest $exchangeRequest, int $userId)
    {
        return DB::transaction(function () use ($exchangeRequest, $userId) {
            // region perform validation
            $userApplier = $this->userInfoRepository->getUserInfoWithWalletsAndExchangeRequests($userId);

            if ($userApplier->id === $exchangeRequest->from_user_id) {
                throw new Exception('You can\'t apply your own exchange request');
            }

            $applierWalletFrom = $userApplier->wallets->where('currency_id', $exchangeRequest->to_currency_id)->first();
            $applierWalletTo = $userApplier->wallets->where('currency_id', $exchangeRequest->from_currency_id)->first();

            if (!isset($applierWalletFrom) || !isset($applierWalletTo)) {
                throw new Exception('You don\'t have this currencies in your wallets');
            }

            if ($applierWalletFrom->balance < $exchangeRequest->to_amount_with_fee) {
                throw new Exception('Your balance is not enough to perform this exchange');
            }
            // endregion

            // region data fetching
            $userCreator = $this->userInfoRepository->getUserInfoWithWalletsAndExchangeRequests($exchangeRequest->from_user_id);

            $creatorWalletTo = $userCreator->wallets->where('currency_id', $exchangeRequest->to_currency_id)->first();
            $creatorWalletFrom = $userCreator->wallets->where('currency_id', $exchangeRequest->from_currency_id)->first();
            //endregion

            // region apply exchange request
            $applierWalletFrom->balance -= $exchangeRequest->to_amount_with_fee;
            $applierWalletFrom->save();

            $applierWalletTo->balance += $exchangeRequest->from_amount;
            $applierWalletTo->save();

            $creatorWalletTo->balance += $exchangeRequest->to_amount;
            $creatorWalletTo->save();

            $exchangeRequest->status = ExchangeRequestStatuses::COMPLETED;
            $exchangeRequest->save();

            ExchangeRequestAppliedEvent::dispatch($exchangeRequest, $creatorWalletFrom, $applierWalletTo);

            return $exchangeRequest;
            // endregion
        });
    }

    /**
     * @throws Exception
     */
    public function closeExchange(int $exchangeRequestId, int $userId): ExchangeRequest
    {
        $exchangeRequest = $this->exchangeRequestsRepository->findByIdAndUserId($exchangeRequestId, $userId);

        if (!isset($exchangeRequest)) {
            throw new Exception('Exchange request not found');
        }

        $userWalletFrom = UserWallet::query()
            ->where('user_id', $userId)
            ->where('currency_id', $exchangeRequest->from_currency_id)
            ->first();

        return DB::transaction(function () use ($exchangeRequest, $userWalletFrom) {
            $userWalletFrom->balance += $exchangeRequest->from_amount;

            $exchangeRequest->status = ExchangeRequestStatuses::CLOSED;
            $exchangeRequest->save();

            return $exchangeRequest;
        });
    }
}
