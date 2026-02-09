<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->string('provider')->default('whatsapp_cloud');
            $table->string('api_url');
            $table->string('api_token');
            $table->string('sender_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['mosque_id', 'provider']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_providers');
    }
};
