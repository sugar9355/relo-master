<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalChargesToBookingFormCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::table('booking_form_charges', function (Blueprint $table) {
            if (!Schema::hasColumn('booking_form_charges', 'total_charges')) {
                $table->integer('total_charges', 255)->nullable();
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
        Schema::table('booking_form_charges', function (Blueprint $table) {
            if (Schema::hasColumn('booking_form_charges', 'total_charges')) {
                $table->dropColumn('total_charges');
            }
        });
    }
}
