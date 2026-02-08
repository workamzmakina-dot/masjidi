<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('features')->nullable();
            $table->json('limits')->nullable();
            $table->timestamps();
        });

        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('custom_domain')->nullable()->unique();
            $table->foreignId('plan_id')->constrained();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('mosque_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('goal_amount', 12, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->foreignId('campaign_id')->constrained();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('mosque_users');
        Schema::dropIfExists('mosques');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('failed_jobs');
    }
};
