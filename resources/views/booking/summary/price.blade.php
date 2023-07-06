<div class="price-head">
    <img src="{{{asset('asset/img/preview-imgs/icon_home.png')}}}">
    <div>Price</div>
</div>
<div class="price-graph">
    <div class="card hvr-shadow w-100 card-body">
        <div class="row mt-3">
            <div class="col-6 text-left">
                <strong>Low</strong>
            </div>
            <div class="col-6 text-right">
                <strong>High</strong>
            </div>
        </div>
        <div class="progress my-2">
            <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="15" aria-valuemin="0"
                aria-valuemax="100"></div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: 33%" aria-valuenow="30" aria-valuemin="0"
                aria-valuemax="100"></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 34%" aria-valuenow="20" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
        <div class="row mt-3">
            <div class="col-6 text-left">
                @if (isset($charges['additional_charges']))
                <strong>${{number_format(($charges['total_charges'] + $charges['additional_charges']) * $accuracy_min, 2)}}</strong>
                @else
                <strong>${{number_format($charges['total_charges'] * $accuracy_min, 2)}}</strong>
                @endif
            </div>
            <div class="col-6 text-right">
                @if (isset($charges['additional_charges']))
                <strong>${{number_format(($charges['total_charges'] + $charges['additional_charges']) * $accuracy_max, 2)}}</strong>
                @else
                <strong>${{number_format($charges['total_charges'] * $accuracy_max, 2)}}</strong>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="price-charges">
    <img src="{{asset('asset/img/preview-imgs/icon_bag.png')}}">
    @php
        if (isset($charges['additional_charges'])) {
            $total_charge = $charges['total_charges'] + $charges['additional_charges'];
        } else {
            $total_charge = $charges['total_charges'];
        }
        $crew_charge = $charges['total_crew_charge'];
        if (isset($charges['reservation_fee'])) {
            $mob_charge = $charges['mob_charges'] + $charges['reservation_fee'];
        } else {
            $mob_charge = $charges['mob_charges'];
        }
    @endphp
    <div>Charges ${{number_format($total_charge, 2)}}</div>
</div>
<div class="price-breakdown">
    Breakdown
</div>
<h6>
    Crew Charges
</h6>
<div class="float-right">${{number_format($crew_charge, 2)}}</div>
<div class="progress" style="margin-right:5rem">
    <span style="width:{{$crew_charge/$total_charge*100}}%;background: #ffc107"></span>
</div>
<h6>
    Mobilization
</h6>
<div class="float-right">${{number_format($mob_charge, 2)}}</div>
<div class="progress" style="margin-right:5rem">
    <span style="width:{{$mob_charge/$total_charge*100}}%;background: #ffc107"></span>
</div>
<h6>
    Insurance (Recommended)
</h6>
<div class="float-right">${{isset($booking->insurance) ? $booking->insurance : 0}}</div>
<div class="progress" style="margin-right:5rem">
    <span style="width:{{$booking->insurance/$total_charge*100}}%;background: #ffc107"></span>
</div>
