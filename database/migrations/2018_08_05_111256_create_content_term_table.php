<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_term', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('term_id');
            $table->timestamps();
            $table->unique(['content_id', 'term_id']);
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_term');
    }
}
