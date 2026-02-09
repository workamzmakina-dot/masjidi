<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->nullable()->index()->constrained();
            $table->foreignId('user_id')->nullable()->index(); // Can be PlatformAdmin or MosqueUser
            $table->string('user_type'); // Morph
            $table->string('event'); // 'create', 'update', 'delete', 'login'
            $table->string('auditable_type')->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['mosque_id', 'created_at']);
        });
    }

    public function down() {
        Schema::dropIfExists('audit_logs');
    }
};
