<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        try {
            User::factory()->create([
                'name' => 'User A',
                'email' => 'usera@mail.com',
                'email_verified_at' => $now,
            ]);

            User::factory()->create([
                'name' => 'User B',
                'email' => 'userb@mail.com',
                'email_verified_at' => $now,
            ]);
        } catch (QueryException $e) {
        }
    }
}
