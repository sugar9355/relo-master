<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageHubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_hubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lat');
            $table->string('lng');
            $table->string('day');
            $table->string('week');
            $table->string('month');
            $table->string('year');
            $table->string('time');
            $table->string('total_sq_feet');
            $table->string('sq_feet');
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
        Schema::dropIfExists('storage_hubs');
    }
}
