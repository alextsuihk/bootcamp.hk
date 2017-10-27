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
            //$table->string('number', 6)->comment(' "course_number"."-"."sequence"');
            $table->integer('course_id')->unsigned()->index(); 
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('sequence')->unsigned()->default(0)->index()->comment('increment when a new lesson is created with the same course');
            $table->string('venue')->nullable();
            $table->string('instructor')->nullable();
            $table->integer('teaching_language_id')->unsigned()->index(); 
            $table->foreign('teaching_language_id')->references('id')->on('teaching_languages');
            $table->date('first_day')->nullable();
            $table->date('last_day')->nullable();
            $table->string('schedule')->nullable()->comment('Every Mon 6~8pm');
            $table->boolean('active')->default(false);
            $table->boolean('deleted')->default(false);
            //$table->string('gitlab_uri')->nullable();
            $table->integer('quota')->nullable()->unsigned();
            $table->text('remark')->nullable();
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
