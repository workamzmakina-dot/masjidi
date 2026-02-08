<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_segment_subscriber', function (Blueprint $table) {
            $table->foreignId('segment_id')->constrained('whatsapp_segments')->onDelete('cascade');
            $table->foreignId('subscriber_id')->constrained('whatsapp_subscribers')->onDelete('cascade');
            
            $table->primary(['segment_id', 'subscriber_id']);
            $table->index(['subscriber_id', 'segment_id']);
        });
    }

    public function down() { Schema::dropIfExists('whatsapp_segment_subscriber'); }
};