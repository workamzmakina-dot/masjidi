<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('donation_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('donation_id')->unique()->constrained()->onDelete('cascade');
            $table->string('receipt_number')->index();
            $table->string('pdf_path');
            $table->timestamp('issued_at');
            $table->timestamps();

            $table->unique(['mosque_id', 'receipt_number']);
        });
    }

    public function down() { Schema::dropIfExists('donation_receipts'); }
};
