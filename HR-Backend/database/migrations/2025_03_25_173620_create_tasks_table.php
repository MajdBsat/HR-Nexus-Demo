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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
<<<<<<<< HEAD:HR-Backend/database/migrations/2025_03_24_000007_create_tasks_table.php
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'in-progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->float('estimated_hours')->nullable();
            $table->float('actual_hours')->nullable();
========
            $table->enum('status', ['pending', 'in-progress', 'completed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', ])->default('medium');
            $table->integer('assigned_to');
            $table->date('due_date')->nullable();
>>>>>>>> 54beccc5ecd6318bd496a89bb55dadd1c77084e1:HR-Backend/database/migrations/2025_03_25_173620_create_tasks_table.php
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
        Schema::dropIfExists('tasks');
    }
};
