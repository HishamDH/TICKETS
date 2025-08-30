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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending')->after('role')
                ->comment('Status of the merchant: pending, active, or rejected');
            $table->timestamp('status_updated_at')->nullable()->after('status')
                ->comment('Timestamp when the status was last updated');
            $table->string('rejection_reason')->nullable()->after('status_updated_at')
                ->comment('Reason for rejection if the status is set to rejected');
            $table->string('acceptance_note')->nullable()->after('rejection_reason')
                ->comment('Note provided when the merchant is accepted');
            $table->dropColumn('is_accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'status_updated_at', 'rejection_reason', 'acceptance_note']);
            $table->boolean('is_accepted')->default(false)->after('role')
                ->comment('Indicates if the merchant is accepted or not');
        });
    }
};
