<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Encrypted credentials for WISH Money or Stripe per Mosque
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('provider'); // 'wish_money', 'stripe'
            $table->text('credentials'); // Encrypted JSON blob
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['mosque_id', 'provider']);
        });

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
            $table->foreignId('worshipper_id')->nullable()->constrained();
            $table->string('transaction_id')->unique(); // Local unique ID
            $table->decimal('amount', 15, 2);
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->string('status')->index(); // 'pending', 'completed', 'failed'
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->timestamps();
        });

        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained();
            $table->string('external_id')->unique(); // Provider transaction ID
            $table->json('provider_response');
            $table->timestamps();
        });

        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('external_id')->nullable()->index();
            $table->json('payload');
            $table->integer('http_status');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('donation_transactions');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('payment_gateways');
    }
};
