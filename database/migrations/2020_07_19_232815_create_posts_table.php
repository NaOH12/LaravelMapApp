<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            $table->string('post_content');
            $table->double('longitude');
            $table->double('latitude');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('tile_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->
                on('users')->onDelete('cascade')->
                onUpdate('cascade');

            $table->foreign('tile_id')->references('id')->
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
        Schema::dropIfExists('posts');
    }

}
