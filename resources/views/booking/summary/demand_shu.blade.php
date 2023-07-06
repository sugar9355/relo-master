<div class="color-select col-xl-8 col-md-12 col-sm-12 col-lg-8  mb-3">
    <div class="avail">
        <h4 class="mt-3 mb-3">Price Placement</h4>
    </div>
    <div style="border-bottom:solid 1px #DCDCDC;padding-bottom: 10px; width: 100%; float:left; margin-bottom: 10px"></div>
    <div class="circle-cell">
        @foreach ($demands as $d)        
        @php
        $min_charge = 0;
        if (isset($d->min)) {
            $min_charge = $charges['shuffle_price'][1] * $d->min + $charges['dropoff_items'] + ($charges['storage'] / 2);
        }
        /* $max_charge = 0;
        if (isset($d->max)) {
            $max_charge = $charges['shuffle_price'][1] * $d->max + $charges['dropoff_items'] + ($charges['storage'] / 2);
        } */
        @endphp
        <div class="cir-con text-center" style="background-color: {{$d->color}};">
       
            <span style="color: black;">{{$d->demand_name}}</span><br>
            @php
                $display_num = (ceil($min_charge) % 5 === 0) ? ceil($min_charge) : round(($min_charge + 5 / 2) / 5) * 5;
            @endphp
            <span style="color: black;">${{$display_num}}+</span>
        </div>
        @endforeach
    </div>
</div>