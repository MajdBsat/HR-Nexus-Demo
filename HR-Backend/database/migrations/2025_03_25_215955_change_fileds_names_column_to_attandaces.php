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
        Schema::table('attendances', function (Blueprint $table) {
            //$table->id();
            $table->date('attendance_date');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->time('break_in');
            $table->time('break_out');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn('date_of_attendance');
            $table->dropColumn('clock_in_time');
            $table->dropColumn('clock_out_time');
            $table->dropColumn('break_in_time');
            $table->dropColumn('break_out_time');
        });
    }
};
