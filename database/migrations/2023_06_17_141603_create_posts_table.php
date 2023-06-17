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
            $table->foreignId('penpos_id');
            $table->foreign('penpos_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('status');
            $table->string('file_photo_loc');
            $table->enum('post_type', ['Single', 'Battle','Dungeon']);
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
