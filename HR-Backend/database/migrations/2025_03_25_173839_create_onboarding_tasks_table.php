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
        Schema::create('onboarding_tasks', function (Blueprint $table) {
            $table->id();
<<<<<<<< HEAD:HR-Backend/database/migrations/2025_03_24_000008_create_hr_project_tasks_table.php
            $table->foreignId('project_id')->constrained('hr_projects')->onDelete('cascade');
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->date('completed_at')->nullable();
            $table->timestamps();

            // Add unique constraint to prevent duplicate tasks in a project
            $table->unique(['project_id', 'task_id']);
========
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->timestamps();
>>>>>>>> 54beccc5ecd6318bd496a89bb55dadd1c77084e1:HR-Backend/database/migrations/2025_03_25_173839_create_onboarding_tasks_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onboarding_tasks');
    }
};
