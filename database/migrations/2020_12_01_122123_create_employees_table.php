<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->string('emp_name');
            $table->string('emp_phone');
            $table->string('emp_guardian');
            $table->string('emp_work_nature');
            $table->integer('emp_basic')->default(0);
            $table->integer('emp_da')->default(0);
            $table->integer('day_amount')->default(0);
            $table->date('emp_doj');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
