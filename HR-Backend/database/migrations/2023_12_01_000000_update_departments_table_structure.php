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
        if (Schema::hasTable('departments')) {
            Schema::table('departments', function (Blueprint $table) {
                // Add columns that might be missing from the older migration
                if (!Schema::hasColumn('departments', 'code')) {
                    $table->string('code')->unique()->nullable();
                }

                if (!Schema::hasColumn('departments', 'description')) {
                    $table->text('description')->nullable();
                }

                if (!Schema::hasColumn('departments', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }

                if (!Schema::hasColumn('departments', 'budget')) {
                    $table->integer('budget')->nullable();
                }

                if (!Schema::hasColumn('departments', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // Drop columns that were added by this migration
            $table->dropColumn(['code', 'description', 'is_active', 'budget', 'deleted_at']);
        });
    }
};
