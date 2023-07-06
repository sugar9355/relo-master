<div class="bar"></div>
<div class="calendar-box row">
    <div class="col-md-6" id="calendar-1">
        @include('booking.summary.cal_shu_left')
    </div>
    <div class="col-md-6" id="calendar-2">
        @include('booking.summary.cal_shu_right')
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        @include('booking.summary.demand_shu')
        @include('booking.summary.inventory')
    </div>
    <div class="col-md-3">
        <div class="price card mt-3" id="price-part">
            <div>
                @include('booking.summary.price_shuffle')
            </div>
            <div>
                <form action="/booking/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data" style="width: 100%">
                    {{ csrf_field() }}
                    <div style="width: 100%; display: flex; align-items: center; padding: 30px;">
                        @php
                        $total_charge = 0;
                        foreach ($charges as $key => $charge) {
                            if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items')
                                $total_charge += $charge;
                        }
                        @endphp
                        <input type="hidden" name="mobilization_charges" value="0">
                        <input type="hidden" name="crew_charges" value="0">
                        <input type="hidden" name="additional_charges" value="0">
                        <input type="hidden" name="insurance_charges" value="{{$total_charge}}">
                        <button id="button-1" class="button icon book-now-btn btn-7a" name="btn_submit" value="7"
                            style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" type="submit">
                            <div id="circle" class="circle"></div> Book Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
