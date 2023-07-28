<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalvosRevivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salvos_revives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salvos_games_id');
            $table->foreign('salvos_games_id')->references('id')->on('salvos_games')->onUpdate('cascade')->onDelete('cascade');
            //$table->dateTime('revive_time');
            $table->timestamps(); //revive_time pake created_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
