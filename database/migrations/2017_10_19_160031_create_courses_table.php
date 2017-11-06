<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('number', 3)->unique();         // e.g. 101, 201
            $table->string('title',50);
            $table->mediumText('abstract');
            $table->integer('level_id')->unsigned()->default(21); 
            $table->foreign('level_id')->references('id')->on('levels');
            //$table->string('gitlab_uri')->nullable();   // e.g. courses/201
            $table->boolean('active')->default(false);
            $table->boolean('deleted')->default(false);
            $table->mediumText('remark')->nullable();
            $table->timestamps();
        });
        //DB::update("ALTER TABLE courses AUTO_INCREMENT = 100;");
    }

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
