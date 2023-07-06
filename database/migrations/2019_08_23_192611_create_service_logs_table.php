<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('truck_id');
            $table->date('from');
            $table->string('miles');
            $table->string('next_miles');
            $table->string('always_miles');
            $table->date('to');
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
        Schema::dropIfExists('service_logs');
    }
}
