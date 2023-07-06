<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_id',255)->unique();
            $table->string('full_name',255);
            $table->string('phone_number',100);
            $table->string('message',100);
            $table->string('count_msg',100)->default(0);
            $table->timestamp('createdat', 0)->useCurrent();
            $table->timestamp('updatedat',0)->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
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
        Schema::dropIfExists('msgs');
    }
}
