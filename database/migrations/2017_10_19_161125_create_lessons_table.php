<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 6);
            $table->integer('course_id')->unsigned(); 
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('instance')->comment('increment when a new lesson is created with the same course');
            $table->string('instructor')->nullable();
            $table->string('venue')->nullable();
            $table->date('first_day')->nullable();
            $table->date('last_day')->nullable();
            $table->string('schedule')->comment('Every Mon 6~8pm');
            //$table->string('gitlab_uri')->nullable();
            $table->integer('quota')->unsigned()->default(0);
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
        Schema::dropIfExists('lessons');
    }
}
