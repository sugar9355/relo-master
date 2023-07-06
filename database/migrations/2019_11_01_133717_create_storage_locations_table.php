<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_storage_request_id');
            $table->string('floor');
            $table->string('zip_code');
            $table->string('location_question1');
            $table->string('location_question2');
            $table->string('flight')->nullable();
            $table->string('stair_type')->nullable();
            $table->string('elevator_type')->nullable();
            $table->string('detail_address');
            $table->string('location_note');
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
        Schema::dropIfExists('storage_locations');
    }
}
