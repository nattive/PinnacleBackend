<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('ApprovedBy')->nullable();
            $table->string('courseCode')->nullable();
            $table->string('videoUrl')->nullable();
            $table->unsignedInteger('sub_category_id')->nullable();
            $table->integer('career_category_id')->nullable();
            $table->string('banner_thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('duration')->nullable();
            $table->string('image_public_id')->nullable();
            $table->string('video_public_id')->nullable();
            $table->string('language')->nullable();
            $table->string('prerequisite')->nullable();
            /**
            *Could be either isPO or isCareer
            */
            $table->string('courseType');
            $table->string('isFree')->default(true);
            $table->integer('no_rated_user')->default('0');
            $table->float('rating_percentage')->default('0');
            $table->integer('total_rating')->default('0');
            $table->string('comment_id')->nullable();
            $table->string('price')->nullable();
            $table->longText('objective')->nullable();
            $table->string('tutor_id');
            $table->string('slug');
            $table->string('course_difficulty')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
// bfinlay/laravel-excel-seeder
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
