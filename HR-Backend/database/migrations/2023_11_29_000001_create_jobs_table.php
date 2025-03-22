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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('location');
            $table->string('department');
            $table->string('job_type'); // Full-time, Part-time, Contract, etc.
            $table->string('job_level'); // Entry, Mid, Senior, etc.
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 3)->default('USD');
            $table->string('salary_period')->default('yearly'); // yearly, monthly, weekly, hourly
            $table->boolean('is_remote')->default(false);
            $table->date('posting_date');
            $table->date('closing_date')->nullable();
            $table->string('status'); // Draft, Published, Closed, Filled
            $table->foreignId('posted_by')->nullable()->constrained('users');
            $table->foreignId('hiring_manager_id')->nullable()->constrained('users');
            $table->integer('vacancies')->default(1);
            $table->json('benefits')->nullable();
            $table->json('skills')->nullable();
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
        Schema::dropIfExists('jobs');
    }
};
