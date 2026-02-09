<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'reference')) {
                $table->string('reference')->after('campaign_id')->nullable()->unique();
                $table->string('donor_name')->nullable();
                $table->string('donor_phone')->nullable();
                $table->string('donor_email')->nullable();
                $table->json('metadata')->nullable();
                $table->string('currency', 3)->default('USD');
            }
        });
    }

    public function down() { }
};
