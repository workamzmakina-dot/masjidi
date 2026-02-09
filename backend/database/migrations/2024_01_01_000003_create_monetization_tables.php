<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('title');
            $table->text('description');
            $table->decimal('goal_amount', 15, 2)->nullable();
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->foreignId('campaign_id')->index()->constrained();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->string('status')->index();
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('donations');
        Schema::dropIfExists('campaigns');
    }
};
