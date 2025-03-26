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
        Schema::create('health_care_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('plan_name');
            $table->text('description')->nullable();
            $table->string('provider');
            $table->string('coverage_type');
            $table->json('coverage_details')->nullable();
            $table->decimal('premium_amount', 10, 2);
            $table->decimal('deductible_amount', 10, 2)->nullable();
            $table->decimal('copay_amount', 10, 2)->nullable();
            $table->date('enrollment_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['active', 'expired', 'pending', 'canceled'])->default('active');
            $table->json('dependents')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('enrollment_start_date')->nullable();
            $table->date('enrollment_end_date')->nullable();
            $table->date('coverage_start_date')->nullable();
            $table->date('coverage_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_care_plans');
    }
};
