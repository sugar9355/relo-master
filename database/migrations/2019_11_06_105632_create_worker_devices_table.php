<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id');
            $table->string('udid');
            $table->string('token');
            $table->enum('status', ['active', 'offline','riding']);
            $table->enum('type', ['android', 'ios']);
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
        Schema::dropIfExists('worker_devices');
    }
}
