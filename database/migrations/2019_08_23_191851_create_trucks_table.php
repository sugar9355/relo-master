<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('samsara_id');
            $table->string('name');
            $table->string('type');
            $table->string('color');
            $table->string('fuel_volume');
            $table->string('year');
            $table->string('reg_no');
            $table->string('fuel_type');
            $table->string('weight');
            $table->string('overall_height');
            $table->string('overall_width');
            $table->string('wheel_base');
            $table->string('gvw_rating');
            $table->string('towing_capacity');
            $table->string('payload_capacity');
            $table->string('towing_capacity_maximum');
            $table->string('cargo_length');
            $table->string('cargo_width');
            $table->string('title_number');
            $table->string('width');
            $table->string('height');
            $table->string('breadth');
            $table->string('volume');
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
        Schema::dropIfExists('trucks');
    }
}
