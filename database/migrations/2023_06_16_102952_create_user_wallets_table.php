<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies', 'id');
            $table->double('balance', 10, 2);

            $table->unique(['user_id', 'currency_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wallets');
    }
};
