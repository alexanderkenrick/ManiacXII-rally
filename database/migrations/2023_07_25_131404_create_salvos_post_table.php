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
        Schema::create('salvos_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teams_id');
            $table->foreign('teams_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('player_hp')->default(10000);
            $table->integer('enemy_hp')->default(10000);
            $table->integer('turn')->default(0);
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
