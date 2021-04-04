<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('att_date')->nullable();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('attendance')->nullable();
            $table->integer('half_day')->default(0);
            $table->integer('paid_leave')->default(0);
            $table->string('works')->nullable();
            $table->integer('adv_amount')->default(0);
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
        Schema::dropIfExists('employee_attendances');
    }
}
