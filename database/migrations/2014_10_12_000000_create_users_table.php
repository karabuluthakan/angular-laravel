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
            $table->string('username', 32)->unique();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 100)->unique();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('avatar_id')->nullable();
            $table->string('password');
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->string('api_token', 60)->nullable()->unique();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
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
