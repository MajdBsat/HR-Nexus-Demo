<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('plan_name');
            $table->text('description')->nullable();
            $table->string('type'); // Health, Life, Auto, Home, Travel, etc.
            $table->string('provider');
            $table->string('policy_number')->nullable();
            $table->json('coverage_details')->nullable();
            $table->decimal('premium_amount', 10, 2)->nullable();
            $table->decimal('deductible_amount', 10, 2)->nullable();
            $table->decimal('coverage_limit', 15, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('status'); // Active, Inactive, Cancelled, Expired, Pending
            $table->json('beneficiaries')->nullable();
            $table->json('documents')->nullable(); // Paths to policy documents
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_plans');
    }
};
