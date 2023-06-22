<?php

namespace Database\Factories;

use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserWalletFactory extends Factory
{
    protected $model = UserWallet::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
