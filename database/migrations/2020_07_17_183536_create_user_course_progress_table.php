<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_progress', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('course_id');
            // $table->unsignedInteger('user_id');
            // $table->integer('total_modules')->default(0);
            // $table->integer('total_modules_taken')->default(0);
            // $table->integer('accumulated_grade')->default(0);
            
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
        Schema::dropIfExists('user_course_progress');
    }
}
