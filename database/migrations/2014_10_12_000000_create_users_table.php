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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombres',100);
            $table->string('apellidos',100);
            $table->string('dni',100)->unique();
            $table->string('gerencia',100);
            $table->string('cargo',50);
            $table->string('genero',50);
            $table->string('email')->unique();
            $table->boolean('asistencia')->default(0);
            $table->string('rol')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
