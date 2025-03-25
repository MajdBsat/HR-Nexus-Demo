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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('location');
            $table->boolean('remote_eligible')->default(false);
            $table->string('employment_type')->default('full-time'); // full-time, part-time, contract, etc.
            $table->date('posting_date');
            $table->date('closing_date')->nullable();
            $table->enum('status', ['draft', 'open', 'closed', 'filled', 'cancelled'])->default('draft');
            $table->unsignedInteger('positions_available')->default(1);
            $table->unsignedInteger('positions_filled')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('hiring_manager_id')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->string('external_job_link')->nullable();
            $table->integer('experience_years_min')->nullable();
            $table->integer('experience_years_max')->nullable();
            $table->json('skills_required')->nullable();
            $table->json('benefits')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
