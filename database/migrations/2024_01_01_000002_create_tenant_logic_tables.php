<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Platform Admin (Global) uses the standard 'users' table or separate
        Schema::create('platform_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Mosque Admins (Tenant Scoped)
        Schema::create('mosque_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->json('preferences')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['mosque_id', 'email']);
        });

        // Worshippers / App Users (Tenant Scoped)
        Schema::create('worshippers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_member')->default(false);
            $table->timestamps();

            $table->unique(['mosque_id', 'email']);
            $table->unique(['mosque_id', 'phone']);
        });

        // Role/Permission setup per Tenant (Simplified Spatie approach)
        Schema::create('tenant_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained();
            $table->string('name'); // e.g., 'Imam', 'Treasurer'
            $table->json('permissions'); 
            $table->timestamps();

            $table->unique(['mosque_id', 'name']);
        });
    }

    public function down() {
        Schema::dropIfExists('tenant_roles');
        Schema::dropIfExists('worshippers');
        Schema::dropIfExists('mosque_users');
        Schema::dropIfExists('platform_admins');
    }
};
