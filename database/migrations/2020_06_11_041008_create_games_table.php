<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('year')->nullable();
            $table->bigInteger('bgg_id')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->integer('players_min')->nullable();
            $table->integer('players_max')->nullable();
            $table->integer('playtime_min')->nullable();
            $table->integer('playtime_max')->nullable();
            $table->float('complexity', 3, 1)->nullable();
            $table->float('rating', 3, 1)->nullable();
            $table->longText('notes')->nullable();
            $table->string('categories')->nullable();
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
        Schema::dropIfExists('games');
    }
}
