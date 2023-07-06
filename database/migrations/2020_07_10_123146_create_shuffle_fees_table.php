<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShuffleFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuffle_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->float('base_rate', 10, 2)->nullable();
            $table->float('charge_cb_ft', 10, 2)->nullable();
            $table->float('curbside_fee', 10, 2)->nullable();
            $table->string('parking_situations', 50)->nullable();
            $table->string('parking_fees', 200)->nullable();
            $table->text('vol_min')->nullable();
            $table->text('vol_max')->nullable();
            $table->text('long_walk_fee')->nullable();
            $table->text('dis_assem_fee')->nullable();
            $table->float('survival_kit')->nullable();
            $table->float('supplies_kit')->nullable();
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
        Schema::dropIfExists('shuffle_fees');
    }
}
