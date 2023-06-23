<?php

namespace Src\Users\Aggregators;

use App\Models\ExchangeRequest;
use Src\ExchangeRequests\DTO\ExchangeRequestDTO;
use Src\Users\DTO\UserDTO;
use Src\Users\DTO\UserInfoDTO;
use Src\Users\Repositories\IUserInfoRepository;
use Src\Users\Wallets\DTO\WalletDTO;

class UserInfoAggregator
{
    public function __construct(
        private readonly IUserInfoRepository $userInfoRepository,
    )
    {
    }

    public function getData(int $userId): UserInfoDTO
    {
        $userInfo = $this->userInfoRepository->getUserInfoWithWalletsAndExchangeRequests($userId);

        return new UserInfoDTO(
            UserDTO::fromModel($userInfo),
            WalletDTO::collection(
                $userInfo->wallets->map(fn ($wallet) => WalletDTO::fromModel($wallet))
            ),
            ExchangeRequestDTO::collection(
                $userInfo->exchangeRequests->map(fn ($exchangeRequest) => ExchangeRequestDTO::fromModel($exchangeRequest))
            )
        );
    }
}
