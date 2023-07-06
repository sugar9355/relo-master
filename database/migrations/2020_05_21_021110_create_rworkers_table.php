<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRworkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rworkers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_crews');
            $table->string('weight', 30);
            $table->integer('wei_min');
            $table->integer('wei_max');
            $table->integer('vol_min');
            $table->integer('vol_max');
            $table->string('volume', 30);
            $table->string('categories', 255);
            $table->string('items', 255);
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
        Schema::dropIfExists('rworkers');
    }
}
