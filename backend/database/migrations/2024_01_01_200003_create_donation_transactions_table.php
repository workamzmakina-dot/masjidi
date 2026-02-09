<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('donation_id')->index()->constrained()->onDelete('cascade');
            $table->string('provider')->default('wish');
            $table->string('provider_txn_id')->nullable()->index();
            $table->string('status')->index();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down() { Schema::dropIfExists('donation_transactions'); }
};
