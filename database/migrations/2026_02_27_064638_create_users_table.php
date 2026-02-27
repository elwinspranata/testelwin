<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 120);
            $table->string('email', 120)->unique();
            $table->string('role', 40);
            $table->uuid('role_id')->nullable();
            $table->string('password');
            $table->string('zone', 120)->nullable();
            $table->timestamps();

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};