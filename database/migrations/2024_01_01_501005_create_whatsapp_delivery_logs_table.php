<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('message_id')->index()->constrained('whatsapp_messages')->onDelete('cascade');
            $table->enum('provider_event', ['sent', 'delivered', 'read', 'failed']);
            $table->json('provider_payload')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();

            $table->index(['mosque_id', 'message_id']);
        });
    }

    public function down() { Schema::dropIfExists('whatsapp_delivery_logs'); }
};