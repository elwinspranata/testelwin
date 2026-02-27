<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 200);
            $table->string('status', 40);
            $table->uuid('owner_id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('proof', 80)->nullable();
            $table->timestamps();

            $table->foreign('owner_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};