<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->nullable()->index()->constrained()->onDelete('cascade');
            $table->string('provider')->default('wish');
            $table->json('headers');
            $table->json('payload');
            $table->string('signature')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('event_type')->nullable();
            $table->timestamp('received_at');
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->string('request_id')->index();
            $table->timestamps();
        });
    }

    public function down() { Schema::dropIfExists('webhook_logs'); }
};
