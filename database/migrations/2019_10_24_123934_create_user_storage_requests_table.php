<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStorageRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_storage_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('s_lat')->nullable();
            $table->string('s_lng')->nullable();
            $table->string('d_lat')->nullable();
            $table->string('d_lng')->nullable();
            $table->string('quotation')->nullable();
            $table->string('distance')->nullable();
            $table->string('over_all_distance')->nullable();
            $table->string('minutes')->nullable();
            $table->string('over_all_minutes')->nullable();
            $table->string('waypoints')->nullable();
            $table->string('way_point_lats')->nullable();
            $table->string('way_points_lngs')->nullable();
            $table->string('s_address')->nullable();
            $table->string('d_address')->nullable();
            $table->string('serviceType')->nullable();
            $table->string('status')->default('Pending');
            $table->string('date_type')->nullable();
            $table->string('prefer_date')->nullable();
            $table->string('prefer_time')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->date('booking_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->tinyInteger('drop')->default(0);
            $table->string('drop_date_type')->nullable();
            $table->string('drop_prefer_date')->nullable();
            $table->string('drop_prefer_time')->nullable();
            $table->string('drop_date')->nullable();
            $table->string('drop_time')->nullable();
            $table->date('drop_booking_date')->nullable();
            $table->string('drop_start_time')->nullable();
            $table->string('drop_end_time')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->string('zonetype')->nullable();
            $table->string('vehicle_schedule')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('charge_deposit')->nullable();
            $table->string('deposit')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('accuracy')->nullable();
            $table->text('packaging')->nullable();
            $table->text('junk_removal')->nullable();
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
        Schema::dropIfExists('user_storage_requests');
    }
}
