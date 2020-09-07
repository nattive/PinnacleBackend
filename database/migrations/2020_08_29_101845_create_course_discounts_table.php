<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('discount');
            $table->string('banner')->nullable();
            $table->string('type'); // percentage //amount
            $table->timestamp('due');
            $table->string('code')->unique();
            $table->boolean('active')->default(true);
            $table->integer('tutor_id');
            $table->integer('course_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('course_discounts');
    }
}
