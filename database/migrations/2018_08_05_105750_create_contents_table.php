<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(1);
            $table->string('slug', 180);
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->longText('body');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->tinyInteger('is_sticky')->default(0);
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unique(['type', 'slug']);
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
