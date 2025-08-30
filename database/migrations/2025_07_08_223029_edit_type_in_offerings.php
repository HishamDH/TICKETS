<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        DB::statement("ALTER TABLE `offerings` MODIFY `type` ENUM('services', 'events') DEFAULT 'events'");
  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `offerings` MODIFY `type` ENUM('events', 'conference', 'restaurant', 'experiences') DEFAULT 'events'");

    }
};
