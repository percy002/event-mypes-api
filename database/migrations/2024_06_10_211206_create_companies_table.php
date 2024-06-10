<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('business_name');
            $table->string('trade_name');
            $table->string('ruc')->unique();
            $table->string('address');
            $table->string('company_email')->unique();
            $table->string('legal_representative_first_name');
            $table->string('legal_representative_last_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
