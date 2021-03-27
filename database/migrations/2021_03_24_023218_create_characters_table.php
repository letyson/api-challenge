<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->uuid('id')->primary();
            $table->string('name');
            $table->string('status');
            $table->string('species');
            $table->string('type');
            $table->string('gender');
            $table->json('origin');
            $table->json('location');
            $table->string('image');
            $table->json('episode');
            //created_at and updated_at automatically
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
        Schema::dropIfExists('characters');
    }
}
