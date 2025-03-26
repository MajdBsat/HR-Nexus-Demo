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
        Schema::create('job_insurance_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('insurance_plan_id')->constrained()->onDelete('cascade');
            $table->boolean('is_default')->default(false);
            $table->decimal('employer_contribution_percentage', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate associations
            $table->unique(['job_id', 'insurance_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_insurance_plans');
    }
};
