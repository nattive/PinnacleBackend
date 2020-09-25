<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('course_module_id');
            // $table->integer('stepInModule')->default(0);
            $table->longText('text');
            // $table->longText('quiz')->nullable();
            $table->longText('objective')->nullable();
            $table->longText('prerequisite')->nullable();
            $table->string('videoPath')->nullable();
            $table->string('duration')->nullable();
            // $table->string('public_id')->nullable();
            $table->string('images')->nullable();
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
        Schema::dropIfExists('course_materials');
    }
}
