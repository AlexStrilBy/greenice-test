<?php

namespace Src\Users\Repositories;

use App\Models\User;

class UserInfoRepository implements IUserInfoRepository
{

    public function getUserInfoWithWallets(int $userId): User
    {
        return User::query()
            ->with('wallets')
            ->where('id', $userId)
            ->firstOrFail();
    }
}
