<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->string('provider')->default('wish')->index();
            $table->enum('mode', ['test', 'live'])->default('test');
            $table->string('merchant_id')->nullable();
            $table->text('api_key_encrypted');
            $table->text('api_secret_encrypted');
            $table->text('webhook_secret_encrypted')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();

            $table->unique(['mosque_id', 'provider']);
        });
    }

    public function down() { Schema::dropIfExists('payment_gateways'); }
};
