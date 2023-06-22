<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\ExchangeRequests\Resources\Enums\ExchangeRequestStatuses;

return new class extends Migration {
    public function up(): void
    {
        $statuses = array_column(ExchangeRequestStatuses::cases(), 'value');


        Schema::create('exchange_requests', function (Blueprint $table) use ($statuses) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users', 'id');
            $table->double('from_amount');
            $table->foreignId('from_currency_id')->constrained('currencies', 'id');
            $table->double('to_amount');
            $table->foreignId('to_currency_id')->constrained('currencies', 'id');
            $table->enum('status', $statuses)->default(ExchangeRequestStatuses::PENDING->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_requests');
    }
};
