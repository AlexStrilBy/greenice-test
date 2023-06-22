<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'USD', 'symbol' => '$'],
            ['code' => 'EUR', 'symbol' => '€'],
            ['code' => 'UAH', 'symbol' => '₴'],
        ];

        Currency::upsert($currencies, ['code'], ['symbol']);
    }
}
