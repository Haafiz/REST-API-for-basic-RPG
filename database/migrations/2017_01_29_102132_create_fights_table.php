<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'fights', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('opponent_id')->unsigned();
                $table->integer('character_id')->unsigned();
                $table->enum('status', ['won', 'lost', 'draw']);
                $table->integer('experience');

                //indexes
                $table->foreign('opponent_id')->references('id')->on('characters');
                $table->foreign('character_id')->references('id')->on('characters');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fights');
    }
}
