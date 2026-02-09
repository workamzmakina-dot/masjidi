<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('language', 10)->default('ar');
            $table->text('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['mosque_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_templates');
    }
};
