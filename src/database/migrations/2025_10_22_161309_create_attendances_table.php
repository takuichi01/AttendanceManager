<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff_users')->onDelete('cascade');
            $table->string('staff_name', 255);
            $table->date('date');
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['勤務外', '出勤中', '休憩中', '退勤済'])->default('勤務外');
            // 勤務状態（勤務外・出勤中・休憩中・退勤済など）
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['staff_id', 'date', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
