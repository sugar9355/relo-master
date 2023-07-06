<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div style="background-color:#007BFF;" class="card-header  text-white text-center">
                <h5 class="mt-1">Moderate</h5>
            </div>
            <div class="card-body">
                @foreach ($selected_items as $item)
                <div class="row p-2">
                    <div class="col-md-6 d-flex align-items-center text-capitalize"><h6>{{$item->item_name}}</h6></div>
                    <div class="col-md-6 d-flex justify-content-between align-items-center">
                        <button class="btn btn-info btn-sm" onclick="update_you_pay('moderate', '-', {{$item->item_id}}, {{$insurance_data['Moderate']['ratio']}})"><i class="fas fa-minus"></i></button>
                        <h6 id="moderate_show_{{$item->item_id}}" class="ml-2 mr-2">0</h6>
                        <button class="btn btn-info btn-sm" onclick="update_you_pay('moderate', '+', {{$item->item_id}}, {{$insurance_data['Moderate']['ratio']}})"><i class="fas fa-plus"></i></button>
                        <input type="hidden" value="0" id="moderate_{{$item->item_id}}">
                    </div>
                </div>
                @endforeach
                <div class="row mt-3">
                    <h5 class="text-center text-dark col-md-12" id="moderate_you_pay_show">You Pay: ${{$insurance_data['Moderate']['you_pay']}}</h5>
                    <input type="hidden" id="moderate_you_pay" value="{{$insurance_data['Moderate']['you_pay']}}">
                </div>
                <div class="row mt-1">
                    <h5 class="text-center text-dark col-md-12" id="moderate_we_cover_show">We Cover: ${{$insurance_data['Moderate']['you_pay'] * $insurance_data['Moderate']['ratio']}}</h5>
                    <input type="hidden" id="moderate_we_cover" value="{{$insurance_data['Moderate']['you_pay'] * $insurance_data['Moderate']['ratio']}}">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary col-md-12" onclick="get_insurance('moderate')">
                    Get Started
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div style="background-color:#28A745;" class="card-header  text-white text-center">
                <h5 class="mt-1">Standard</h5>
            </div>
            <div class="card-body">
                @foreach ($selected_items as $item)
                <div class="row p-2">
                    <div class="col-md-6 d-flex align-items-center text-capitalize"><h6>{{$item->item_name}}</h6></div>
                    <div class="col-md-6 d-flex justify-content-between align-items-center">
                        <button class="btn btn-success btn-sm" onclick="update_you_pay('standard', '-', {{$item->item_id}}, {{$insurance_data['Standard']['ratio']}})"><i class="fas fa-minus"></i></button>
                        <h6 id="standard_show_{{$item->item_id}}" class="ml-2 mr-2">0</h6>
                        <button class="btn btn-success btn-sm" onclick="update_you_pay('standard', '+', {{$item->item_id}}, {{$insurance_data['Standard']['ratio']}})"><i class="fas fa-plus"></i></button>
                        <input type="hidden" value="0" id="standard_{{$item->item_id}}">
                    </div>
                </div>
                @endforeach
                <div class="row mt-3">
                    <h5 class="text-center text-success col-md-12" id="standard_you_pay_show">You Pay: ${{$insurance_data['Standard']['you_pay']}}</h5>
                    <input type="hidden" id="standard_you_pay" value="{{$insurance_data['Standard']['you_pay']}}">
                </div>
                <div class="row mt-1">
                    <h5 class="text-center text-success col-md-12" id="standard_we_cover_show">We Cover: ${{$insurance_data['Standard']['you_pay'] * $insurance_data['Standard']['ratio']}}</h5>
                    <input type="hidden" id="standard_we_cover" value="{{$insurance_data['Standard']['you_pay'] * $insurance_data['Standard']['ratio']}}">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success col-md-12" onclick="get_insurance('standard')">
                    Get Started
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-header bg-warning text-white text-center">
                <h5 class="mt-1">Recommended</h5>
            </div>
            <div class="card-body">
                @foreach ($selected_items as $item)
                <div class="row p-2">
                    <div class="col-md-6 d-flex align-items-center text-capitalize"><h6>{{$item->item_name}}</h6></div>
                    <div class="col-md-6 d-flex justify-content-between align-items-center">
                        <button class="btn btn-warning btn-sm text-white" onclick="update_you_pay('recommended', '-', {{$item->item_id}}, {{$insurance_data['Recommended']['ratio']}})"><i class="fas fa-minus"></i></button>
                        <h6 id="recommended_show_{{$item->item_id}}" class="ml-2 mr-2">0</h6>
                        <button class="btn btn-warning btn-sm text-white" onclick="update_you_pay('recommended', '+', {{$item->item_id}}, {{$insurance_data['Recommended']['ratio']}})"><i class="fas fa-plus"></i></button>
                        <input type="hidden" value="0" id="recommended_{{$item->item_id}}">
                    </div>
                </div>
                @endforeach
                <div class="row mt-3">
                    <h5 class="text-center text-warning col-md-12" id="recommended_you_pay_show">You Pay: ${{$insurance_data['Recommended']['you_pay']}}</h5>
                    <input type="hidden" id="recommended_you_pay" value="{{$insurance_data['Recommended']['you_pay']}}">
                </div>
                <div class="row mt-1">
                    <h5 class="text-center text-warning col-md-12" id="recommended_we_cover_show">We Cover: ${{$insurance_data['Recommended']['you_pay'] * $insurance_data['Recommended']['ratio']}}</h5>
                    <input type="hidden" id="recommended_we_cover" value="{{$insurance_data['Recommended']['you_pay'] * $insurance_data['Recommended']['ratio']}}">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning text-white col-md-12" onclick="get_insurance('recommended')">
                    Get Started
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-header bg-warning text-white text-center">
                <h5 class="mt-1">No Insurance</h5>
            </div>
            <div class="card-body">
                <input type="hidden" id="no_insurance_you_pay" value="0">
            </div>
            <div class="card-footer">
                <button class="btn btn-warning text-white col-md-12" onclick="get_insurance('no_insurance')">
                    Get Started
                </button>
            </div>
        </div>
    </div>
</div>