<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasurePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasure_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teams_id');
            $table->foreign('teams_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('start_session');
            $table->dateTime('end_session')->nullable();
            $table->integer('dig_left');
            $table->boolean('poisoned');
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
        Schema::dropIfExists('treasure_post');
    }
}
