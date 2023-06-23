<?php

namespace Src\Users\Repositories;

use App\Models\User;

class UserInfoRepository implements IUserInfoRepository
{

    public function getUserInfoWithWalletsAndExchangeRequests(int $userId): User
    {
        return User::query()
            ->with('wallets', 'exchangeRequests')
            ->where('id', $userId)
            ->firstOrFail();
    }
}
