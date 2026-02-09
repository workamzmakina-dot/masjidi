<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('subscriber_id')->nullable()->constrained('whatsapp_subscribers')->onDelete('set null');
            $table->foreignId('segment_id')->nullable()->constrained('whatsapp_segments')->onDelete('set null');
            $table->foreignId('template_id')->nullable()->constrained('whatsapp_templates')->onDelete('set null');
            
            $table->string('to_phone_e164');
            $table->text('body');
            $table->enum('status', ['queued', 'sending', 'sent', 'failed', 'cancelled'])->default('queued');
            
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            
            $table->string('provider_name')->nullable();
            $table->string('provider_message_id')->nullable()->index();
            $table->string('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['mosque_id', 'status']);
            $table->index(['mosque_id', 'scheduled_at']);
        });
    }

    public function down() { Schema::dropIfExists('whatsapp_messages'); }
};