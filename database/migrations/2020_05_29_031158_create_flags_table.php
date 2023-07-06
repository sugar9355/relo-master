<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color', 10);
            $table->string('conditions', 50);
            $table->string('categories', 50)->nullable();
            $table->string('items', 50)->nullable();
            $table->integer('num_flights')->nullable();
            $table->string('type_flights', 10)->nullable();
            $table->string('zones', 100)->nullable();
            $table->text('addresses');
            $table->string('apt', 100);
            $table->string('reason_title', 50)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('flags');
    }
}
