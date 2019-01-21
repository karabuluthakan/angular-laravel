<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file');
            $table->string('file_name');
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->string('mime', 100);
            $table->string('file_sha1', 100)->unique();
            $table->smallInteger('width')->nullable();
            $table->smallInteger('height')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->longText('info')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->tinyInteger('status')->default(1);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('avatar_id')->references('id')->on('uploads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_avatar_id_foreign');
        });
        Schema::dropIfExists('uploads');
    }
}
