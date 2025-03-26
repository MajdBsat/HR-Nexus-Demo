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
        Schema::create('insurance_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('provider');
            $table->string('plan_type');
            $table->decimal('monthly_premium', 10, 2);
            $table->decimal('annual_deductible', 10, 2)->nullable();
            $table->decimal('out_of_pocket_max', 10, 2)->nullable();
            $table->decimal('copay', 10, 2)->nullable();
            $table->decimal('coinsurance', 5, 2)->nullable(); // Percentage value
            $table->boolean('includes_dental')->default(false);
            $table->boolean('includes_vision')->default(false);
            $table->boolean('includes_life')->default(false);
            $table->boolean('includes_disability')->default(false);
            $table->json('additional_benefits')->nullable();
            $table->date('effective_date');
            $table->date('expiration_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_plans');
    }
};
