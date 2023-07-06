@php
$total_charge = 0;
foreach ($charges as $key => $charge) {
    if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items' && $key != 'curbside_fees' && $key != 'items_price')
        $total_charge += $charge;
    elseif ($key == 'curbside_fees')
        $total_charge -= $charge;
}
@endphp
@php
    $total_pickup_price = 0;
    $total_dropoff_price = 0;
    foreach ($pickup_prices as $p => $p_price) {
        $total_pickup_price += $p_price;
        $total_dropoff_price += $dropoff_prices[$p];
    }
@endphp
<div class="card mt-3 p-3" data-toggle="modal" data-target="#pickup_prices">
    <div class="row">
        <div class="col-12 mt-1 w-100" style="cursor: pointer">
        <h6>
            <span class="text-info border border-info border-top-0 border-left-0 border-right-0">Pickup Price <i class="fas fa-info-circle fa-sm" style="color: black"></i> :</span> $<span class="float-right total_pickup_price">{{number_format($total_pickup_price, 2)}}</span>
        </h6>
        </div>
    </div>
</div>

<div class="card mt-3 p-3" data-toggle="modal" data-target="#dropoff_prices">
    <div class="row">
        <div class="col-12 mt-1 w-100" style="cursor: pointer">
        <h6>
            <span class="text-info border border-info border-top-0 border-left-0 border-right-0">Dropoff Price <i class="fas fa-info-circle fa-sm" style="color: black"></i>:</span> $<span class="float-right total_dropoff_price">{{number_format($total_dropoff_price, 2)}}</span>
        </h6>
        </div>
    </div>
</div>

<div class="modal fade item_prices" id="pickup_prices" tabindex="-1" role="dialog" aria-labelledby="Pickup Prices" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Pickup Prices</h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">item</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Pickup</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Storage</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Remove</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="p_p_list">
                        @foreach ($pickup_prices as $p => $p_price)
                        <tr id="item_row_{{$p}}">
                            <td class="text-center text-info" style="font-size: 14px">{{$item_names[$p]}}</td>
                            <td class="text-center" style="font-size: 14px">$<span class="pickup_price_{{$p}}">{{number_format($p_price,2)}}</span></td>
                            <td class="text-center" style="font-size: 14px">$<span class="sto_{{$p}}">{{number_format($storages[$p],2)}}</span></td>
                            <td class="text-center" style="font-size: 14px"><span class="text-danger" onclick="removeItem('{{$selected_items[$p]->pk_booking_item_id}}', '{{$p}}');"><i class="fas fa-trash-alt fa-sm"></i></span></td>
                            <td class="text-center" style="font-size: 14px">
                                <span class="text-danger" onclick="decreaseQty('{{$selected_items[$p]->pk_booking_item_id}}', '{{$p}}');" title="descrese"><i class="fas fa-minus fa-sm"></i></span>
                                <span class="qty_{{$p}}">{{$selected_items[$p]->quantity}}</span>
                                <span class="text-danger" onclick="increaseQty('{{$selected_items[$p]->pk_booking_item_id}}', '{{$p}}');" title="inscrese"><i class="fas fa-plus fa-sm"></i></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade item_prices" id="dropoff_prices" tabindex="-1" role="dialog" aria-labelledby="Dropoff Prices" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Dropoff Prices</h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">item</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Dropoff</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Storage</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Remove</th>
                            <th scope="col" class="text-info text-uppercase text-center" style="font-size: 14px">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dropoff_prices as $d => $d_price)
                        <tr id="item_row_{{$d}}">
                            <td class="text-center text-info" style="font-size: 14px">{{$item_names[$d]}}</td>
                            <td class="text-center" style="font-size: 14px">$<span class="dropoff_price_{{$d}}">{{number_format($d_price,2)}}</span></td>
                            <td class="text-center" style="font-size: 14px">$<span class="sto_{{$d}}">{{number_format($storages[$d],2)}}</span></td>
                            <td class="text-center" style="font-size: 14px"><span class="text-danger" onclick="removeItem('{{$selected_items[$d]->pk_booking_item_id}}', '{{$d}}');"><i class="fas fa-trash-alt fa-sm"></i></span></td>
                            <td class="text-center" style="font-size: 14px">
                                <span class="text-danger" onclick="decreaseQty('{{$selected_items[$d]->pk_booking_item_id}}', '{{$d}}');" title="descrese"><i class="fas fa-minus fa-sm"></i></span>
                                <span class="qty_{{$d}}">{{$selected_items[$d]->quantity}}</span>
                                <span class="text-danger" onclick="increaseQty('{{$selected_items[$d]->pk_booking_item_id}}', '{{$d}}');" title="inscrese"><i class="fas fa-plus fa-sm"></i></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3 p-3">
    <div class="row">
        <div class="col-12 mt-1 w-100">
        <h6>
            Storage Price: <div class="float-right">$<span id="total_sto_price">{{number_format($charges['storage'], 2)}}</span></div>
        </h6>
        </div>
    </div>
</div>

<div class="card mt-3 p-3">
    <div class="row">
        <div class="col-12 mt-1 w-100">
            @if ($charges['parking_fees'] != 0)
            <h6>
                Parking Flat fees: <span class="float-right">${{number_format($charges['parking_fees'], 2)}}</span></br>
            </h6>
            @endif

            @if ($charges['dis_assem_fees'] != 0)
            <h6>
                Dis-assembly Fees: <span class="float-right">${{number_format($charges['dis_assem_fees'], 2)}}</span></br>
            </h6>
            @endif

            @if ($charges['long_walk_fees'] != 0)
            <h6>
                Longwalks: <span class="float-right">${{number_format($charges['long_walk_fees'], 2)}}</span></br>
            </h6>
            @endif

            @if (isset($charges['supplies_kit']) && $charges['supplies_kit'] != 0)
            <h6>
                Supplies Kit: <span class="float-right">${{number_format($charges['supplies_kit'], 2)}}</span></br>
            </h6>
            @endif

            @if (isset($charges['survival_kit']) && $charges['survival_kit'] != 0)
            <h6>
                Survival Kit: <span class="float-right">${{number_format($charges['survival_kit'], 2)}}</span></br>
            </h6>
            @endif
        </div>
    </div>
</div>

<div style="" class="hov card mt-3 p-3 blink_me" data-toggle="modal" data-target="#insurance_modal">
    <div class="row">
        <div class="col-12 mt-1 w-100">
            <h6>
               Insurance: <span class="float-right" id="ins_charge_show">${{isset($insurance_price) ? $numberformat($insurance_price, 2) : number_format($insurance_data['Recommended']['you_pay'], 2)}}</span></br> <span id="insurance_type" style="font-size:11px">(Recommended)</span>
            </h6>
        </div>
    </div>
</div>