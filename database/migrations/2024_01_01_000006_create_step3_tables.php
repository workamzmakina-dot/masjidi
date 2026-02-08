<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('prayer_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('method')->default('MWL'); // MWL, ISNA, Egypt, Makkah, Karachi, Tehran, Jafari
            $table->string('timezone')->default('UTC');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('manual_adjustments')->nullable(); // {fajr: 2, dhuhr: 0...}
            $table->json('iqama_offsets')->nullable(); // {fajr: 20, dhuhr: 15...}
            $table->boolean('use_iqama_static_times')->default(false);
            $table->json('iqama_static_times')->nullable();
            $table->timestamps();
        });

        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->foreignId('speaker_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // video, audio, pdf, link
            $table->string('media_path')->nullable();
            $table->string('external_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->date('recorded_at')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->string('recurrence')->nullable(); // none, weekly
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('fatwa_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('fatwa_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('fatwa_categories');
            $table->string('user_name')->nullable();
            $table->string('user_contact')->nullable(); // Email or WhatsApp
            $table->text('question');
            $table->text('answer')->nullable();
            $table->foreignId('answered_by')->nullable()->constrained('mosque_users');
            $table->enum('status', ['pending', 'draft', 'published', 'private_replied'])->default('pending');
            $table->boolean('is_public')->default(true);
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });

        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('message');
            $table->enum('type', ['info', 'warning', 'emergency'])->default('info');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('fatwa_questions');
        Schema::dropIfExists('fatwa_categories');
        Schema::dropIfExists('events');
        Schema::dropIfExists('lectures');
        Schema::dropIfExists('speakers');
        Schema::dropIfExists('prayer_settings');
    }
};