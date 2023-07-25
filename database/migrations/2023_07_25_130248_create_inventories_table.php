<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->foreignId('teams_id');
            $table->foreign('teams_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreignId('items_id');
            $table->foreign('items_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('cascade');

            
            $table->integer('count');
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
        Schema::dropIfExists('inventories');
    }
}
