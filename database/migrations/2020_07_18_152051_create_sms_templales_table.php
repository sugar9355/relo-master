<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTemplalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_templales', function (Blueprint $table) {
             $table->increments('id');
            $table->string('template_id');
            $table->string('template_subject');
            $table->string('template');
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
        Schema::dropIfExists('sms_templales');
    }
}
