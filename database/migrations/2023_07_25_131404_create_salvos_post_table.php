<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalvosPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salvos_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teams_id');
            $table->foreign('teams_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('start_session');
            $table->integer('player_hp');
            $table->integer('enemy_hp');
            $table->enum('status',['battle','dead']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salvos_post');
    }
}
