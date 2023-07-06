<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_moving_request_id');
            $table->string('qty');
            $table->string('insurance_type');
            $table->string('category_name');
            $table->string('ratio');
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
        Schema::dropIfExists('insurance_details');
    }
}
