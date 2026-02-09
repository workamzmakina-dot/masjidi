<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('phone_e164');
            $table->string('locale', 5)->default('ar');
            $table->enum('status', ['active', 'opted_out', 'blocked'])->default('active');
            $table->enum('source', ['website', 'admin_import', 'event_signup', 'donation'])->default('website');
            $table->timestamp('last_opt_in_at')->nullable();
            $table->timestamp('last_opt_out_at')->nullable();
            $table->timestamps();

            $table->unique(['mosque_id', 'phone_e164']);
            $table->index(['mosque_id', 'status']);
        });
    }

    public function down() { Schema::dropIfExists('whatsapp_subscribers'); }
};