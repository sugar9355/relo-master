@extends('admin.layout.base')

@section('title', 'Add Item Category ')

@section('content')

<style>
    .btn-box {
        display: flex;
        align-items: flex-end;
    }
</style>

<form class="form-horizontal" action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data" role="form">
{{csrf_field()}}

<div class="row">
    <div class="col-md-6">
            
        <div class="card h-100">

            <div class="card-header bg-dark text-white header-elements-inline">
            <h6 class="card-title">Item Details</h6>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="col-form-label">@lang('admin.category_name')</label>
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" requaired id="name" placeholder="Categroy Name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Equipment Required</label>
                            <select name="equipment[]" id="equipment" multiple="multiple" class="form-control select" data-fouc>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}" >{{ $equipment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group col-md-12">
                            
                            <label for="name" class="col-form-label">Select Hoisting</label>
                            <div class="form-check form-check-switch form-check-switch-left">
                                <label class="form-check-label d-flex align-items-center">
                                    <input name="hoisting" value="1" type="checkbox" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="danger" >
                                    
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Select Material</label>
                            <select class="form-control" name="material_type" id="material_type">
                                <option value="" selected hidden>Select Material</option>
                                @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flag" class="col-md-12 col-form-label">@lang('admin.flag')</label>
                            @foreach ($flags as $flag)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flag" id="flag_{{$flag->id}}" value="{{$flag->id}}">
                                    <label class="form-check-label" style="color: {{$flag->color}}"><i class="icon-flag7"></i></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="stackable" class="col-form-label">Stackable</label>
                            <div class="form-check form-check-switch form-check-switch-left">
                                <label class="form-check-label d-flex align-items-center">
                                    <input name="stackable" type="checkbox" value="1" id="stackable"
                                        class="form-check-input form-check-input-switch" data-on-text="Stackable"
                                        data-off-text="Unstackable" data-on-color="success" data-off-color="default" checked />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group stackable_mul_container">
                            <label for="stackable_multiplier">Multiplier</label>
                            <input type="number" class="form-control col-md-6 mt-1" name="stackable_multiplier" id="stackable_multiplier" step="0.01" value="1" />
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Categories</label>
                            <select id="categories" class="form-control select" data-fouc>
                                <option selected disabled>select</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-dark text-white header-elements-inline">
                <h5 class="card-title">Questions</h5>
                <div class="header-elements">
                    <div class="list-icons">
                    <button type="button" id="btn_add" class="btn btn-success"><i class="icon-plus3"></i> Add More</button>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div id="questions" class="card-body">
                    <div class="form-group">
                        
                        <div class="row">
                            <div class="col-md-1 text-right"><span class="badge bg-teal p-2">Q. 1</span></div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" value="" name="question[1]" placeholder="Enter Question text">
                            </div>
                            <div class="col-md-3 form-check form-check-switch form-check-switch-left">
                                <label class="form-check-label d-flex align-items-center">
                                    <input name="question_allow[1]" value="1" type="checkbox" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="danger" >
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- wrapping part --}}
<div class="card mt-2">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h6 class="card-title">Wrapping</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label for="wrapping_material" class="col-form-label">Material Used</label>
                <select class="form-control" name="wrapping_material" id="wrapping_material">
                    <option value="" selected hidden>Select Material</option>
                    @foreach($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_qty" class="col-form-label">Qty</label>
                <input class="form-control" type="text" name="wrapping_qty" id="wrapping_qty" placeholder="Qty" value="0" />
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_time" class="col-form-label">Time to Wrap</label>
                <input class="form-control" type="text" name="wrapping_time" id="wrapping_time" placeholder="Time to Wrap" value="0" />
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_price" class="col-form-label">Price</label>
                <input class="form-control" type="text" name="wrapping_price" id="wrapping_price" placeholder="Wrapping Price" value="0" />
            </div>
        </div>
    </div>
</div>

{{-- dimension part --}}
<div class="card mt-2">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h6 class="card-title">Item Dimension</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.weight') Min</label>
                <input class="form-control" type="text" name="weight_min" id="weight_min" placeholder="@lang('admin.weight')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.weight') Max</label>
                <input class="form-control" type="text" name="weight_max" id="weight_max" placeholder="@lang('admin.weight')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.price') Min</label>
                <input class="form-control" type="text" name="junk_price_min" id="junk_price_min" placeholder="Junk Price" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.price') Max</label>
                <input class="form-control" type="text" name="junk_price_max" id="junk_price_max" placeholder="Junk Price" value="0" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">Price for Storage</label>
                <input class="form-control" type="text" name="storage_price" id="storage_price" placeholder="Price for Storage" value="0" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.width')</label>
                <input class="form-control volume-factor" type="text" name="width" id="width" placeholder="@lang('admin.width')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.height')</label>
                <input class="form-control volume-factor" type="text" name="height" id="height" placeholder="@lang('admin.height')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.breadth')</label>
                <input class="form-control volume-factor" type="text" name="breadth" id="breadth" placeholder="@lang('admin.breadth')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.volume')</label>
                <input class="form-control" type="text" name="volume" id="volume" placeholder="@lang('admin.volume')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.multiplier')</label>
                <input class="form-control" type="text" name="multiplier" id="multiplier" placeholder="@lang('admin.multiplier')" value="0" />
            </div>
            <div class="form-group col-md-2 col-lg-1 text-center">
                <label for="">@lang('admin.packing_volume')</label>
                <input class="form-control" type="text" name="packing_volume" id="packing_volume" placeholder="@lang('admin.packing_volume')" value="0" />
            </div>
        </div>
    </div>
</div>

<div>
    <div class="card mt-3">
        <div class="card-header bg-dark text-white header-elements-inline">
            <h6 class="card-title">Time</h6>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        <div class="card-body" id="time">
            @include('admin.category.includes.time')
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Create Category </button>
                <a href="{{route('admin.category.index')}}" class="btn btn-default btn-outline-dark">@lang('admin.cancel')</a>
            </div>
        </div>
    </div>
</div>

</form>



@endsection
@section('scripts')
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<script>
    var material_price = 0;
    var wrapping_mat_price = 0;
    var wrapping_qty = 0;
    var charge_cb_ft = parseFloat('{{$charge_cb_ft}}');

    function cal_volume() {
        var width = $("#width").val();
        var height = $("#height").val();
        var breadth = $("#breadth").val();
        var multiplier = $("#multiplier").val();
        
        var volume = ((width * height * breadth) / 1728).toFixed(2);
        var p_vol = (multiplier * volume).toFixed(2);
        
        $("#volume").val(volume);
        $('#packing_volume').val(p_vol);
        $('#packing_volume').trigger('keyup');
    }

    $(function()
    {
        $('.sh-move').hide();
        $('#sh_show_btn').click(function() {
            var sh_show = $('#sh_show').val();
            if (sh_show == 1) {
                $('.sh-move').hide();
                $('.small-move').show();
                $('#sh_show').val(0);
                $('#sh_show_btn').removeClass('btn-primary').addClass('btn-secondary');
            } else {
                $('.sh-move').show();
                $('.small-move').hide();
                $('#sh_show').val(1);
                $('#sh_show_btn').addClass('btn-primary').removeClass('btn-secondary');
            }
        })

        $('#wrapping_material').change(function() {
            var id = $(this).val();
            @foreach ($materials as $material)
            if ('{{$material->id}}' == id) {
                wrapping_mat_price = parseFloat('{{$material->price}}');
                wrapping_qty = parseInt('{{$material->qty}}');
                if (parseInt($('#wrapping_qty').val()) > wrapping_qty) {
                    $('#wrapping_qty').val(wrapping_qty);
                }
                $('#wrapping_price').val(wrapping_mat_price * parseInt($('#wrapping_qty').val()));
            }
            @endforeach
        });

        $('#wrapping_qty').keyup(function() {
            if (parseInt($('#wrapping_qty').val()) > wrapping_qty) {
                $('#wrapping_qty').val(wrapping_qty);
            }
            $('#wrapping_price').val(wrapping_mat_price * parseInt($('#wrapping_qty').val()));
        });

        $('#material_type').change(function() {
            var id = $(this).val()
            var materials = []
            @foreach ($materials as $material)
            if ('{{$material->id}}' == id) {
                material_price = parseFloat('{{$material->price}}');
                $('#junk_price_min').val(material_price * parseFloat($('#weight_min').val()))
                $('#junk_price_max').val(material_price * parseFloat($('#weight_max').val()))
            }
            @endforeach
        })

        $('#weight_min').keyup(function() {
            $('#junk_price_min').val(material_price * parseFloat($('#weight_min').val()))
        })

        $('#weight_max').keyup(function() {
            $('#junk_price_max').val(material_price * parseFloat($('#weight_max').val()))
        })

        $('.volume-factor').keyup(function() {
            cal_volume()
        })

        $('#multiplier').keyup(function() {
            cal_volume()
        })

        var index = 1;
        $("#btn_add").on('click', function() {
            index = index + 1;
            var res  = '<div id="div_' + index + '" class="form-group">';
                res += '<div class="row">';
                res += '<div class="col-md-1 text-right"><span class="badge bg-teal p-2">Q. ' + index + '</span></div>';
                res += '<div class="col-md-6">';
                res += '<input class="form-control" type="text" value="" name="question[' + index + ']" id="question_' + index + '" placeholder="Enter Question text">';
                res += '</div><div class="col-md-3 form-check form-check-switch form-check-switch-left">';
                res += '<label class="form-check-label d-flex align-items-center">';
                res += '<input name="question_allow[' + index + ']" value="1" type="checkbox" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="danger" >';
                res += '</label></div><div class="col-md-2">';
                res += '<button class="btn btn-danger" type="button" onclick="remove_q(' + index + ')">Remove</button>';
                res += '</div></div></div>';

            $("#questions").append(res);
            $('.form-check-input-switch').bootstrapSwitch()
        });

        $('.add-flight').click(function() {
            // var num_worker = $(this).data('num_worker')
            var current_flight = parseInt($(this).val())
            $(this).val(current_flight + 1)
            for (num_worker = 1; num_worker <= 4; num_worker++) {
                var res = ''
                if (num_worker == 1) {
                    res = '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2 text-info text-center"><label>Flights</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" disabled />'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_flights[' + (current_flight + 1) + '][0]" id="sh_flights_' + (current_flight + 1) + '_0" /></div>'
                    res += '</div></div>'
                    res += '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2">'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div>'
                    res += '<div class="col-4 form-group btn-box"><button class="form-control btn btn-danger" type="button" onclick="remove_flight(' + (current_flight + 1) + ')">Remove</button></div></div></div>'
                } else if (num_worker == 2) {
                    res = '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2 text-info text-center"><label>Flights</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" disabled />'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_flights[' + (current_flight + 1) + '][0]" id="sh_flights_' + (current_flight + 1) + '_0" /></div>'
                    res += '</div></div>'
                    res += '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2">'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_flights[' + (current_flight + 1) + '][1]" id="sh_flights_' + (current_flight + 1) + '_1" /></div></div></div>'
                } else {
                    res = '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2 text-info text-center"><label>Flights</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" disabled />'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][0]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_0" />'
                    res += '</div></div></div>'
                    res += '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2">'
                    res += '</div><div class="form-group col-2 small-move"><label>Min Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_min[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_min_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Med Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_med[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_med_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div><div class="form-group col-2 small-move"><label>Max Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="flights_max[' + num_worker + '][' + (current_flight + 1) + '][1]" id="flights_max_' + num_worker + '_' + (current_flight + 1) + '_1" />'
                    res += '</div></div></div>'
                }
                $('#flights-box-' + num_worker).append(res)
                var sh_show = $('#sh_show').val();
                if (sh_show == 1) {
                    $('.sh-move').show();
                    $('.small-move').hide();
                } else {
                    $('.sh-move').hide();
                    $('.small-move').show();
                }
            }

        })

        $('.add-elevator').click(function() {
            // var num_worker = $(this).data('num_worker')
            var elevator_type = $(this).data('type')
            var current_floor = parseInt($(this).val())
            $(this).val(current_floor + 1)
            for (num_worker = 1; num_worker <= 4; num_worker++) {
                var id = elevator_type + '-' + num_worker + '-' + (current_floor + 1)
                var res = ''
                if (num_worker == 1) {
                    res = '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2 text-info text-center"><label>Floor</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" disabled />'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_' + elevator_type + '[' + (current_floor + 1) + '][0]" id="sh_' + elevator_type + '_' + (current_floor + 1) + '_0" /></div>'
                    res += '</div></div>'
                    res += '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2">'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="col-3 form-group btn-box"><button class="form-control btn btn-danger" type="button" data-target_e_type="' + elevator_type + '" data-target_floor="' + (current_floor + 1) + '" onclick="remove_elevator()">Remove</button></div></div></div>'
                } else if (num_worker == 2) {
                    res = '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2 text-info text-center"><label>Floor</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" disabled />'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_' + elevator_type + '[' + (current_floor + 1) + '][0]" id="sh_' + elevator_type + '_' + (current_floor + 1) + '_0" /></div>'
                    res += '</div></div>'
                    res += '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2">'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 sh-move"></div>'
                    res += '<div class="form-group col-3 sh-move"><label>Multiplier</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="sh_' + elevator_type + '[' + (current_floor + 1) + '][1]" id="sh_' + elevator_type + '_' + (current_floor + 1) + '_1" /></div></div></div>'
                } else {
                    res = '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2 text-center text-info"><label>Floor</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" disabled />'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][0]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_0" />'
                    res += '</div></div></div><div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2">'
                    res += '</div><div class="form-group col-3 small-move"><label>Required Time</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_time[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_time_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div><div class="form-group col-3 small-move"><label>Additional Delay</label>'
                    res += '<input class="form-control text-right" type="text" value="0" name="' + elevator_type + '_delay[' + num_worker + '][' + (current_floor + 1) + '][1]" id="' + elevator_type + '_delay_' + num_worker + '_' + (current_floor + 1) + '_1" />'
                    res += '</div></div></div>'
                }
                $('#' + elevator_type + '-box-' + num_worker).append(res)
                var sh_show = $('#sh_show').val();
                if (sh_show == 1) {
                    $('.sh-move').show();
                    $('.small-move').hide();
                } else {
                    $('.sh-move').hide();
                    $('.small-move').show();
                }
            }

        })

        $('.multiply').click(function() {
            var num_worker = $(this).data('num_worker')
            var by = parseFloat($('#by_' + num_worker).val())
            var current_flight = parseInt($('.add-flight').val())
            for (i = 0; i <= current_flight; i++) {
                $('#flights_min_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_min_1_' + i + '_0').val()) * by).toFixed(2))
                $('#flights_med_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_med_1_' + i + '_0').val()) * by).toFixed(2))
                $('#flights_max_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_max_1_' + i + '_0').val()) * by).toFixed(2))
                $('#flights_min_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_min_1_' + i + '_1').val()) * by).toFixed(2))
                $('#flights_med_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_med_1_' + i + '_1').val()) * by).toFixed(2))
                $('#flights_max_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_max_1_' + i + '_1').val()) * by).toFixed(2))
            }

            $('.add-elevator').each(function(index) {
                var type = $(this).data('type')
                var current_floor = parseInt($(this).val())
                for (i = 0; i <= current_floor; i++) {
                    $('#' + type + '_time_' + num_worker + '_' + i + '_0').val((parseFloat($('#' + type + '_time_1_' + i + '_0').val()) * by).toFixed(2))
                    $('#' + type + '_delay_' + num_worker + '_' + i + '_0').val((parseFloat($('#' + type + '_delay_1_' + i + '_0').val()) * by).toFixed(2))
                    $('#' + type + '_time_' + num_worker + '_' + i + '_1').val((parseFloat($('#' + type + '_time_1_' + i + '_1').val()) * by).toFixed(2))
                    $('#' + type + '_delay_' + num_worker + '_' + i + '_1').val((parseFloat($('#' + type + '_delay_1_' + i + '_1').val()) * by).toFixed(2))
                }
            })

            for (j = 0; j < 2; j++) {
                $('#bulkhead_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#bulkhead_time_1_1to3_' + j).val()) * by).toFixed(2))
                $('#bulkhead_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#bulkhead_delay_1_1to3_' + j).val()) * by).toFixed(2))
                $('#bulkhead_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#bulkhead_time_1_4to5_' + j).val()) * by).toFixed(2))
                $('#bulkhead_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#bulkhead_delay_1_4to5_' + j).val()) * by).toFixed(2))
                $('#bulkhead_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#bulkhead_time_1_8to12_' + j).val()) * by).toFixed(2))
                $('#bulkhead_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#bulkhead_delay_1_8to12_' + j).val()) * by).toFixed(2))
                $('#en_steps_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#en_steps_time_1_1to3_' + j).val()) * by).toFixed(2))
                $('#en_steps_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#en_steps_delay_1_1to3_' + j).val()) * by).toFixed(2))
                $('#en_steps_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#en_steps_time_1_4to5_' + j).val()) * by).toFixed(2))
                $('#en_steps_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#en_steps_delay_1_4to5_' + j).val()) * by).toFixed(2))
                $('#en_steps_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#en_steps_time_1_8to12_' + j).val()) * by).toFixed(2))
                $('#en_steps_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#en_steps_delay_1_8to12_' + j).val()) * by).toFixed(2))
                $('#groundfloor_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#groundfloor_time_1_1to3_' + j).val()) * by).toFixed(2))
                $('#groundfloor_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#groundfloor_delay_1_1to3_' + j).val()) * by).toFixed(2))
                $('#groundfloor_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#groundfloor_time_1_4to5_' + j).val()) * by).toFixed(2))
                $('#groundfloor_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#groundfloor_delay_1_4to5_' + j).val()) * by).toFixed(2))
                $('#groundfloor_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#groundfloor_time_1_8to12_' + j).val()) * by).toFixed(2))
                $('#groundfloor_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#groundfloor_delay_1_8to12_' + j).val()) * by).toFixed(2))
            }
        })

        $('#disassembly').on('switchChange.bootstrapSwitch', function(event, state) {
            if (!state) {
                $('.disassembly-body').hide()
            } else {
                $('.disassembly-body').show()
            }
        })

        $('*[id^="check_num_workers_"]').on('switchChange.bootstrapSwitch', function(event, state) {
            var num_worker = $(this).data('num_worker')
            if (!state) {
                $('#v-pills-tabContent-' + num_worker + ' .form-control').prop("readonly", true)
            } else {
                $('#v-pills-tabContent-' + num_worker + ' .form-control').prop("readonly", false)
            }
        })

        $('#stackable').on('switchChange.bootstrapSwitch', function(event, state) {
            if (!state) {
                $('.stackable_mul_container').fadeOut();
                var storage_price = charge_cb_ft * parseFloat($('#packing_volume').val());
                $('#storage_price').val(storage_price);
            } else {
                $('.stackable_mul_container').fadeIn();
                var storage_price = charge_cb_ft * parseFloat($('#packing_volume').val()) * parseFloat($('#stackable_multiplier').val());
                $('#storage_price').val(storage_price);
            }
        })

        $('#stackable').on('switchChange.bootstrapSwitch', function(event, state) {
            if (!state) {
                $('.stackable_mul_container').fadeOut();
                $('#stackable_multiplier').val(1);
                cal_price_storage()
            } else {
                $('.stackable_mul_container').fadeIn();
                cal_price_storage()
            }
        })

        $('#stackable_multiplier').change(function() {
            cal_price_storage()
        })

        $('#stackable_multiplier').keyup(function() {
            cal_price_storage()
        })

        $('#packing_volume').keyup(function() {
            cal_price_storage()
        })

        $('.volume-factor').keyup(function() {
            cal_volume()
        })

        $('#multiplier').keyup(function() {
            cal_volume()
        })

        $('#categories').change(function() {
            var category_id = $(this).val()
            $.ajax({
                url: "/admin/category_duplicate/" + category_id,
                type: "GET",
                success: function(data, status) {
                    if (status === 'success') {
                        $('#time').empty()
                        $('#time').append(data)
                        $('.form-check-input-switch').bootstrapSwitch()
                        $('.card [data-action=collapse]:not(.disabled)').on('click', function (e) {
                            var $target = $(this),
                                slidingSpeed = 150;

                            e.preventDefault();
                            $target.parents('.card').toggleClass('card-collapsed');
                            $target.toggleClass('rotate-180');
                            $target.closest('.card').children('.card-header').nextAll().slideToggle(slidingSpeed);
                        })
                        $('#disassembly').on('switchChange.bootstrapSwitch', function(event, state) {
                            if (!state) {
                                $('.disassembly-body').hide()
                            } else {
                                $('.disassembly-body').show()
                            }
                        })
                        var sh_show = $('#sh_show').val();
                        if (sh_show == 1) {
                            $('.sh-move').show();
                            $('.small-move').hide();
                        } else {
                            $('.sh-move').hide();
                            $('.small-move').show();
                        }

                        // Re-Define btn handler
                        $('#sh_show_btn').click(function() {
                            var sh_show = $('#sh_show').val();
                            if (sh_show == 1) {
                                $('.sh-move').hide();
                                $('.small-move').show();
                                $('#sh_show').val(0);
                                $('#sh_show_btn').removeClass('btn-primary').addClass('btn-secondary');
                            } else {
                                $('.sh-move').show();
                                $('.small-move').hide();
                                $('#sh_show').val(1);
                                $('#sh_show_btn').addClass('btn-primary').removeClass('btn-secondary');
                            }
                        })

                        $('*[id^="check_num_workers_"]').on('switchChange.bootstrapSwitch', function(event, state) {
                            var num_worker = $(this).data('num_worker')
                            if (!state) {
                                $('#v-pills-tabContent-' + num_worker + ' .form-control').prop("readonly", true)
                            } else {
                                $('#v-pills-tabContent-' + num_worker + ' .form-control').prop("readonly", false)
                            }
                        })
                    }
                },
                error: function(data, status) {
                    console.log(status)
                }
            })
        })
    });

    function cal_price_storage() {
        var storage_price = (charge_cb_ft * parseFloat($('#packing_volume').val()) * parseFloat($('#stackable_multiplier').val())).toFixed(2);
        $('#storage_price').val(storage_price);
    }

    function remove_flight(i) {
        for (j = 1; j <= 4; j++) {
            $('.flights-' + j + '-' + i).remove()
        }
    }

    function remove_elevator() {
        var e_type = $(event.target).data('target_e_type')
        var floor = $(event.target).data('target_floor')
        for (j = 1; j <= 4; j++) {
            $('.' + e_type + '-' + j + '-' + floor).remove()
        }
    }

    function remove_q(index)
    {
        $("#div_"+index).empty();
    }
</script>
@endsection
