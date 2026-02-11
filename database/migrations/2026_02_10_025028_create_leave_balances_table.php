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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
            // 1. The "Base" days for this year (e.g., 14)
            $table->decimal('allocated_days', 5, 2)->default(0); 
            // 2. The days moved from last year (e.g., 5)
            $table->decimal('carried_forward', 5, 2)->default(0); 
            // 3. The "Live" balance (what she has left to spend)
            $table->decimal('balance', 5, 2)->default(0); 
            $table->integer('year'); 
            $table->timestamps();

            $table->unique(['user_id', 'leave_type_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
