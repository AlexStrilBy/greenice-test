<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Database\Seeder;

class UserWalletsSeeder extends Seeder
{
    public function run(): void
    {
        // Grab the currency IDs
        $usd = Currency::where('code', 'USD')->firstOrFail()->id;
        $uah = Currency::where('code', 'UAH')->firstOrFail()->id;
        $eur = Currency::where('code', 'EUR')->firstOrFail()->id;

        // Fetch the users
        $userA = User::where('email', 'usera@mail.com')->firstOrFail();
        $userB = User::where('email', 'userb@mail.com')->firstOrFail();

        // Create wallets for User A
        UserWallet::insertOrIgnore([
            'user_id' => $userA->id,
            'currency_id' => $usd,
            'balance' => 100,
        ]);

        UserWallet::insertOrIgnore([
            'user_id' => $userA->id,
            'currency_id' => $uah,
            'balance' => 500,
        ]);

        // Create wallets for User B
        UserWallet::insertOrIgnore([
            'user_id' => $userB->id,
            'currency_id' => $usd,
            'balance' => 10,
        ]);

        UserWallet::insertOrIgnore([
            'user_id' => $userB->id,
            'currency_id' => $uah,
            'balance' => 2500,
        ]);

        UserWallet::insertOrIgnore([
            'user_id' => $userB->id,
            'currency_id' => $eur,
            'balance' => 400,
        ]);
    }
}
