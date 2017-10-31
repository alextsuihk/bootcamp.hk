<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attachment_id')->unsigned()->index();
            $table->foreign('attachment_id')->references('id')->on('attachments');
            $table->string('path');
            $table->integer('revision')->unsigned()->default(0)->index();
            $table->boolean('disabled')->default(false);
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
        Schema::dropIfExists('attachment_revisions');
    }
}
