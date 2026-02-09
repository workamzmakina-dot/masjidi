<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Central Feature Definitions
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'whatsapp_broadcast', 'ai_fatwa', 'donations'
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // SaaS Tiers
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price_monthly', 10, 2);
            $table->json('limits'); // e.g., {"whatsapp": 1000, "storage_gb": 10}
            $table->timestamps();
        });

        // Plan-Feature Junction
        Schema::create('feature_plan', function (Blueprint $table) {
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('feature_id')->constrained()->onDelete('cascade');
            $table->primary(['plan_id', 'feature_id']);
        });

        // The Central Tenant Registry
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // URL: /m/al-markaz
            $table->string('custom_domain')->nullable()->unique(); // White-labeling
            $table->foreignId('plan_id')->constrained();
            $table->enum('status', ['active', 'suspended', 'trialing'])->default('trialing');
            $table->json('settings')->nullable(); // UI branding, prayer methods
            $table->softDeletes();
            $table->timestamps();

            $table->index('slug');
            $table->index('custom_domain');
        });

        // Subscription History & Overrides
        Schema::create('mosque_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->foreignId('plan_id')->constrained();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('stripe_id')->nullable()->index();
            $table->timestamps();
        });

        // Granular Feature Toggles per Tenant
        Schema::create('mosque_feature_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->foreignId('feature_id')->constrained();
            $table->boolean('enabled')->default(true);
            $table->json('custom_limits')->nullable(); // Override plan defaults
            $table->timestamps();
            
            $table->unique(['mosque_id', 'feature_id']);
        });

        // Usage Tracking for Monthly Resets
        Schema::create('usage_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained();
            $table->string('feature_name'); // e.g., 'whatsapp_sent'
            $table->unsignedInteger('current_usage')->default(0);
            $table->date('reset_date');
            $table->timestamps();

            $table->unique(['mosque_id', 'feature_name', 'reset_date']);
        });
    }

    public function down() {
        Schema::dropIfExists('usage_counters');
        Schema::dropIfExists('mosque_feature_overrides');
        Schema::dropIfExists('mosque_subscriptions');
        Schema::dropIfExists('mosques');
        Schema::dropIfExists('feature_plan');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('features');
    }
};
