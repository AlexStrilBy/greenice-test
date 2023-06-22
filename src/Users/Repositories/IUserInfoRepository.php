<?php

namespace Src\Users\Repositories;

interface IUserInfoRepository
{
    public function getUserInfoWithWallets(int $userId);
}
