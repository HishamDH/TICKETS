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
        Schema::create('paid_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->string('item_type');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->double('quantity')->default(1);
            $table->double('price');
            $table->double('discount')->default(0.0);
            $table->string('code')->unique();
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_reservations');
    }
};
