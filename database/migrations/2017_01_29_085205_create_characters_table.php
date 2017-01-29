<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'characters', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('age')->unsigned();
                $table->integer('attack')->unsigned();
                $table->integer('defense')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();

                $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('characters');
    }
}
