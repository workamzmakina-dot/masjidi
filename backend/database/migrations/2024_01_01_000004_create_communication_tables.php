<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('phone');
            $table->string('name')->nullable();
            $table->boolean('is_opted_in')->default(true);
            $table->timestamp('opted_in_at')->useCurrent();
            $table->timestamps();

            $table->unique(['mosque_id', 'phone']);
        });

        Schema::create('whatsapp_segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('name'); // e.g., 'Weekly Donors', 'Lecture Attendees'
            $table->timestamps();
        });

        Schema::create('whatsapp_subscriber_segment', function (Blueprint $table) {
            $table->foreignId('subscriber_id')->constrained('whatsapp_subscribers')->onDelete('cascade');
            $table->foreignId('segment_id')->constrained('whatsapp_segments')->onDelete('cascade');
            $table->primary(['subscriber_id', 'segment_id']);
        });

        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('external_template_id'); // Meta's template ID
            $table->string('name');
            $table->text('content');
            $table->string('status'); // 'approved', 'pending', 'rejected'
            $table->timestamps();
        });

        Schema::create('whatsapp_message_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->foreignId('subscriber_id')->constrained('whatsapp_subscribers');
            $table->foreignId('template_id')->nullable()->constrained('whatsapp_templates');
            $table->text('custom_message')->nullable();
            $table->string('status')->default('queued')->index(); // 'queued', 'processing', 'sent', 'failed'
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('whatsapp_delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('whatsapp_message_queue');
            $table->string('external_message_id')->nullable()->index();
            $table->enum('event', ['sent', 'delivered', 'read', 'failed']);
            $table->timestamp('occurred_at');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('whatsapp_delivery_logs');
        Schema::dropIfExists('whatsapp_message_queue');
        Schema::dropIfExists('whatsapp_templates');
        Schema::dropIfExists('whatsapp_subscriber_segment');
        Schema::dropIfExists('whatsapp_segments');
        Schema::dropIfExists('whatsapp_subscribers');
    }
};
