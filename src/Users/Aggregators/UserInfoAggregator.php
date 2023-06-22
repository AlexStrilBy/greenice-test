<?php

namespace Src\Users\Aggregators;

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
        $userWithWallets = $this->userInfoRepository->getUserInfoWithWallets($userId);

        return new UserInfoDTO(
            UserDTO::fromModel($userWithWallets),
            WalletDTO::collection(
                $userWithWallets->wallets->map(fn ($wallet) => WalletDTO::fromModel($wallet))
            )
        );
    }
}
