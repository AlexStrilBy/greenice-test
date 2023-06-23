<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_wallet_id')->constrained('user_wallets', 'id');
            $table->foreignId('to_wallet_id')->constrained('user_wallets', 'id');
            $table->double('from_amount');
            $table->double('to_amount');
            $table->double('system_fee');
            $table->foreignId('system_fee_currency_id')->constrained('currencies', 'id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
