<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->string('isCotF_tutor')->default('false');
            $table->string('isPO_tutor')->default('true');
            $table->string('isActive')->default('false');
            $table->string('rating')->nullable();
            $table->string('image')->nullable();
            $table->longText('about')->nullable();
            $table->string('files')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('youTube')->nullable();
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
        Schema::dropIfExists('tutors');
    }
}
