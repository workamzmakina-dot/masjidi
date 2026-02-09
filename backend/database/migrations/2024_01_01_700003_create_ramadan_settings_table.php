<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ramadan_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->boolean('taraweeh_enabled')->default(false);
            $table->time('iftar_time')->nullable();
            $table->time('suhoor_time')->nullable();
            $table->json('announcements')->nullable();
            $table->timestamps();

            $table->unique('mosque_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ramadan_settings');
    }
};
