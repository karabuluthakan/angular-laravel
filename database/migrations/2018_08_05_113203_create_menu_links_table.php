<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id')->index();
            $table->tinyInteger('type')->default(1);
            $table->string('route')->nullable();
            $table->string('permalink')->nullable();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->unsignedInteger('parent')->nullable();
            $table->string('perm')->nullable();
            $table->tinyInteger('sort')->default(0);
            $table->text('parameters')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('parent')->references('id')->on('menu_links')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_links');
    }
}
