<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('art_tiles', function (Blueprint $table) {
            $table->id();
            $table->integer('x');
            $table->integer('y');
            $table->bigInteger('parent_tile_id')->unsigned();

            $table->foreign('parent_tile_id')->references('id')->
            on('tiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('art_tiles');
    }
}
