<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('art_posts', function (Blueprint $table) {
            $table->id();
            $table->double('longitude');
            $table->double('latitude');
            $table->double('rotation');
            $table->bigInteger('postable_id')->unsigned();
            $table->string('postable_type');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('tile_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->
                on('users')->onDelete('cascade')->
                onUpdate('cascade');

            $table->foreign('tile_id')->references('id')->
                on('art_tiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('art_posts');
    }
}
