<?php

namespace Src\Users\Repositories;

use App\Models\User;

interface IUserInfoRepository
{
    public function getUserInfoWithWalletsAndExchangeRequests(int $userId): User;
}
