<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('white_label_brandings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->string('logo_path')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('font_family')->nullable();
            $table->string('custom_domain')->nullable();
            $table->timestamps();

            $table->unique('mosque_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('white_label_brandings');
    }
};
