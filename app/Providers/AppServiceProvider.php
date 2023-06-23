<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\ExchangeRequests\Repositories\ExchangeRequestsRepository;
use Src\ExchangeRequests\Repositories\IExchangeRequestsRepository;
use Src\Users\Repositories\IUserInfoRepository;
use Src\Users\Repositories\UserInfoRepository;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IUserInfoRepository::class => UserInfoRepository::class,
        IExchangeRequestsRepository::class => ExchangeRequestsRepository::class,
    ];


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
