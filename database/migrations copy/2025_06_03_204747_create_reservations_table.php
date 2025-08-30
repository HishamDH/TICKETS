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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('reservation_date'); // تاريخ الحجز
            $table->time('start_time'); // بداية الحجز
            $table->time('end_time');   // نهاية الحجز
            $table->double('price')->default(0.0); // سعر الحجز
            $table->integer('chairs')->default(1); // عدد الكراسي
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // حالة الحجز
            $table->json('additional_data')->nullable(); // بيانات إضافية (اختياري)
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // معرف المستخدم الذي قام بالحجز
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
