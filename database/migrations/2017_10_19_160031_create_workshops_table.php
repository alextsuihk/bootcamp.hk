<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 3)->unique();         // e.g. 101, 201
            $table->string('title',50);
            $table->text('abstract');
            $table->boolean('is_active')->default(false);
            $table->integer('level_id')->unsigned()->default(21); 
            $table->foreign('level_id')->references('id')->on('levels');
            $table->integer('next_lesson')->unsigned()->default(1);
            $table->timestamps();
        });
        DB::update("ALTER TABLE workshops AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
}
