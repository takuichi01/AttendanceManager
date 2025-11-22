<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('break_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_application_id')->constrained('attendance_applications')->onDelete('cascade');
            $table->unsignedBigInteger('break_time_id')->nullable();
            $table->time('before_break_start_time')->nullable();
            $table->time('before_break_end_time')->nullable();
            $table->time('after_break_start_time')->nullable();
            $table->time('after_break_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('break_applications');
    }
}
