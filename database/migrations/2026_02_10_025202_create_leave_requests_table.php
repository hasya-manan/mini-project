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
        Schema::create('leave_requests', function (Blueprint $table) {
           $table->id();
           $table->foreignId('team_id')->constrained()->onDelete('cascade');
           $table->foreignId('user_id')->constrained()->onDelete('cascade');
           $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
           $table->date('start_date');
           $table->date('end_date');
           $table->decimal('total_days', 5, 2); // Calculated automatically (e.g., 3 days)
           $table->text('reason')->nullable();
           $table->string('status')->default('pending');
            // Admin details
           $table->foreignId('actioned_by')->nullable()->constrained('users'); // Who approved/rejected
           $table->timestamp('actioned_at')->nullable();
           $table->text('admin_notes')->nullable(); 
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
