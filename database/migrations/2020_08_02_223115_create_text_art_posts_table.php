<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextArtPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_art_posts', function (Blueprint $table) {
            $table->id();
            $table->string('text_content');
            $table->integer('colour')->unsigned();
            $table->integer('font')->unsigned();
            $table->double('size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_art_posts');
    }
}
