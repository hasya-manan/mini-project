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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Annual, Sick, Emergency
            $table->json('employment_tiers')->nullable();  // This stores your logic: {"0": 14, "2": 16, "5": 21}
            $table->integer('default_days')->default(14);
            $table->boolean('allow_carry_forward')->default(false);
            $table->integer('max_carry_forward_days')->default(0); // e.g., max 5 days
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
