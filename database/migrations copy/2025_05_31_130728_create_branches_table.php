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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('location');
            $table->integer('tables')->default(0);
            $table->float('hour_price')->default(0);
            $table->time('open_at')->nullable();
            $table->time('close_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('gallery')->nullable();
            $table->foreignId('restaurent_id')->constrained('users','id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
