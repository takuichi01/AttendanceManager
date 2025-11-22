<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff_users')->onDelete('cascade');
            $table->date('attendance_date')->nullable();
            $table->time('before_work_start_time')->nullable();
            $table->time('before_work_end_time')->nullable();
            $table->time('after_work_start_time')->nullable();
            $table->time('after_work_end_time')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('approval_flag')->default(0);
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
        Schema::dropIfExists('attendance_applications');
    }
}
