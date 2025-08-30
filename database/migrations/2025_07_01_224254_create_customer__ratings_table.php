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
        Schema::create('customer__ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade');
            $table->foreignId('service_id')->constrained("offerings")->onDelete('cascade');
            $table->unique(['user_id', 'service_id']);
            //$table->foreignId('merchant_id')->constrained("users")->onDelete('cascade');
            $table->decimal('rating', 2, 1)->default(0);
            $table->text('review')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer__ratings');
    }
};
