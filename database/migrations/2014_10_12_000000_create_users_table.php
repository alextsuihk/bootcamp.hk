<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 16)->unique();  // min: 8, alphanumeric; all lower case
            $table->string('nickname', 20)->nullable();
            $table->string('email', 80)->unique();
            $table->string('email_token', 64)->nullable();
            $table->datetime('email_token_created_at')->default('2000-01-01 00:00:00');
            $table->string('email_verified')->default(false);
            $table->string('password');
            $table->boolean('disabled')->default(false);
            $table->rememberToken();
            $table->string('facebook_id')->index()->nullable();
            $table->string('google_id')->index()->nullable();
            $table->string('gitlab_id')->index()->nullable();
            $table->string('mobile',8)->unique()->nullable();
            $table->boolean('mobile_verify')->default(false);
            $table->boolean('whatapps_verify')->default(false);
            $table->boolean('instructor')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('anonymous')->default(true);
            $table->integer('language_id')->unsigned()->nullable();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('special_needs')->nullable()->comment('e.g. Disability, Dietary');
            $table->timestamps();
        });
        DB::update("ALTER TABLE users AUTO_INCREMENT = 10200;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
