<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJunkInsuranceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('junk_insurance_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_junk_request_id');
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
        Schema::dropIfExists('junk_insurance_details');
    }
}
