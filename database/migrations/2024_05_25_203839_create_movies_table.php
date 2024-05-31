<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('pos')->nullable();
            $table->string('year_2023')->nullable();
            $table->string('year_2022')->nullable();
            $table->string('title');
            $table->string('director');
            $table->string('year');
            $table->string('country');
            $table->string('length');
            $table->string('genre');
            $table->string('colour');
            $table->boolean('is_favorite')->default(false);
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
        Schema::dropIfExists('movies');
    }
}
