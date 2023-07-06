@php
    $step_count = count($booking_location) - 1;
    $array = $booking_location->toArray();
    $out = array_splice($array, 1, 1);
    $length = count($array);
    $booking_location = array_replace($array, array($length => $out[0]));
@endphp
<div class="bg-light p-3 border rounded">
    <div class="border-bottom" style="display: flex; align-items: center;">
        <h5 class="pb-3">Billing Address</h5>
        <button class="btn btn-sm btn-warning mb-3 text-white" style="margin-left: 20px; font-size: 16px" data-toggle="modal" data-target="#add-loc-pop">Add </button>
    </div>

    <div id="locations">
    @for ($i = 0; $i <= $step_count; $i++)
    <div class="bg-white p-2 rounded border">
        <div class="form-check">
            <input type="checkbox" class="form-check-input b_l" name="billing_addy" value="">
            <label class="form-check-label" for="">
                {{-- @if ($i == 0)
                <strong>Same as pickup address</strong>
                @else
                <strong>Same as delivery address</strong>
                @endif
                <br> --}}
                {{$booking_location[$i]->location}}</label>
        </div>
    </div>
    @endfor
    @if (isset($additional_location))
    @foreach ($additional_location as $item)
    <div class="bg-white p-2 rounded border">
        <div class="form-check">
            <input type="checkbox" class="form-check-input b_l" name="billing_addy" value="">
            <label class="form-check-label" for="">
                {{-- @if ($i == 0)
                <strong>Same as pickup address</strong>
                @else
                <strong>Same as delivery address</strong>
                @endif
                <br> --}}
                {{$item->zipcode}} {{$item->street}} {{$item->city}} {{$item->state}} USA</label>
        </div>
    </div>
    @endforeach
    @endif
    </div>
    {{-- <div class="p-2 rounded">
        <div class="custom-control custom-checkbox border-top">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1"><strong>Same as pickup address</strong>
                <br>
                American Falls, Idaho, United States</label>
        </div>
    </div> --}}
</div>

<div class="modal fade" id="add-loc-pop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Add New Billing Information</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <h5 class="border-bottom pb-2 mt-4">Personal Information <small class="float-right">(*required field)</small>
                </h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">First Name*</label>
                        <input type="text" class="form-control" id="n_b_fn">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Last Name*</label>
                        <input type="text" class="form-control" id="n_b_ln">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Phone Number*</label>
                        <input type="text" class="form-control" id="n_b_pn">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Email*</label>
                        <input type="text" class="form-control" id="n_b_em">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Street Address*</label>
                        <input type="text" class="form-control" id="n_b_st">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Apt, suit, etc</label>
                        <input type="text" class="form-control" id="n_b_apt">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">City*</label>
                        <input type="text" class="form-control" id="n_b_ct">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">State*</label>
                        <select class="form-control" id="n_b_state">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>				
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ZIP Code*</label>
                        <input type="text" class="form-control" id="n_b_zc" maxlength="5">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-dark" id="save_loc">Save</button>
            </div>
        </div>
    </div>
</div>
