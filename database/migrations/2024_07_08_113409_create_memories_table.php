<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriesTable extends Migration
{
    public function up()
    {
        Schema::create('memories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('destination')->nullable();
            $table->integer('nights')->nullable();
            $table->integer('days')->nullable();
            $table->time('departure_time')->nullable();
            $table->string('departure_location')->nullable();
            $table->text('schedule')->nullable();
            $table->text('thoughts')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memories');
    }
}