<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('super_admin')->after('password');
            }
        });

        Schema::table('mosques', function (Blueprint $table) {
            if (!Schema::hasColumn('mosques', 'created_by_user_id')) {
                $table->foreignId('created_by_user_id')->nullable()->after('plan_id')->constrained('users');
            }
        });
    }

    public function down() { }
};
