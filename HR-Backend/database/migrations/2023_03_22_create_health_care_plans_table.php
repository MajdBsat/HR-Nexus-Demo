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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan_name');
            $table->text('description')->nullable();
            $table->string('provider');
            $table->string('coverage_type');
            $table->json('coverage_details')->nullable();
            $table->decimal('premium_amount', 10, 2);
            $table->decimal('deductible_amount', 10, 2);
            $table->decimal('copay_amount', 10, 2);
            $table->date('enrollment_date');
            $table->date('effective_date');
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending', 'expired'])->default('pending');
            $table->json('dependents')->nullable();
            $table->timestamps();
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
