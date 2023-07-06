<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubStatusToBookingFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_form', function (Blueprint $table) {
            if (!Schema::hasColumn('booking_form', 'sub_status')) {
                $table->string('sub_status', 100)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_form', function (Blueprint $table) {
            if (Schema::hasColumn('booking_form', 'sub_status')) {
                $table->dropColumn('sub_status');
            }
        });
    }
}
