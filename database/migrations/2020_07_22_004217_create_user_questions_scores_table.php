<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuestionsScoresTable extends Migration
{
    // /**
    //  *      
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     Schema::create('user_questions_scores', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedInteger('course_module');
    //         $table->unsignedInteger('user_id');
    //         $table->integer('score');
    //         $table->string('number_of_correct_answers')->nullable();
    //         $table->string('number_of_wrong_answers')->nullable();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('user_questions_scores');
    // }
}
