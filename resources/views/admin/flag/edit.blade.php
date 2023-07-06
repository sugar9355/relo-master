@extends('admin.layout.base')

@section('title', 'Edit Recommended Workers ')

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h5 class="card-title">Flags</h5>
    </div>
    <div class="card-body">

        <form class="form-horizontal" action="{{route('admin.flag.update', $flag->id)}}" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-1 pl-3">
                    <label class="mt-1">Color</label>
                    <span class="input-group-prepend">
                        <input name="color" type="color" class="form-control form-control-lg" style="height: 40px" required value="{{$flag->color}}">
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Conditions</label>
                        <select id="conditions" name="conditions[]" class="form-control select" data-container-css-class="bg-teal-400" multiple required>
                            <option value="zones" @if (in_array('zones', explode(',', $flag->conditions))) selected @endif>Zones</option>
                            <option value="items" @if (in_array('items', explode(',', $flag->conditions)))) selected @endif>Items</option>
                            <option value="flights" @if (in_array('flights', explode(',', $flag->conditions)))) selected @endif>Flights</option>
                            <option value="addresses" @if (in_array('addresses', explode(',', $flag->conditions)))) selected @endif>Addresses</option>
                        </select>
                    </div>
                </div>
            </div>

            @if (isset($flag->zones))
            <div class="row" id="zone_option_box">
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Zones</label>
                        <select id="zones" name="zones[]" class="form-control select" data-container-css-class="bg-orange-400" multiple>
                            @foreach ($zones as $zone)
                                <option value="{{$zone->id}}" @if (in_array($zone->id, explode(',', $flag->zones))) selected @endif>{{$zone->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @else
            <div class="row" id="zone_option_box" style="display: none">
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Zones</label>
                        <select id="zones" name="zones[]" class="form-control select" data-container-css-class="bg-orange-400" multiple>
                            @foreach ($zones as $zone)
                                <option value="{{$zone->id}}">{{$zone->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($flag->categories))
            <div class="row item_options" id="cat_option_box">
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Categories</label>
                        <select id="categories" name="categories[]" class="form-control select" data-container-css-class="bg-pink-400" multiple>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if (in_array($category->id, explode(',', $flag->categories))) selected @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @else
            <div class="row item_options" id="cat_option_box" style="display: none">
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Categories</label>
                        <select id="categories" name="categories[]" class="form-control select" data-container-css-class="bg-pink-400" multiple>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

            <div class="row item_options" id="item_option_box" @if (!isset($flag->items)) style="display: none" @endif>
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Items</label>
                        <select id="items" name="items[]" class="form-control select" data-container-css-class="bg-pink-400" multiple>
                            @foreach ($items as $item)
                                <option value="{{$item->id}}" @if (in_array($item->id, explode(',', $flag->items))) selected @endif>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row flights_options" id="num_flights_option_box" @if (!isset($flag->num_flights)) style="display: none" @endif>
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Number of Flights</label>
                        <select id="num_flights" name="num_flights" class="form-control select" data-container-css-class="bg-blue-400">
                            @for ($i = 0; $i <= $max_num_flights; $i++)
                                <option value="{{$i}}" @if ($i == $flag->num_flights) selected @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="row flights_options" id="type_flights_option_box" @if (!isset($flag->type_flights)) style="display: none" @endif>
                <div class="col-md-6 pl-3">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Number of Flights</label>
                        <select id="type_flights" name="type_flights" class="form-control select" data-container-css-class="bg-blue-400">
                            <option value="wide" @if ($flag->type_flights == 'wide') selected @endif>Wide</option>
                            <option value="narrow" @if ($flag->type_flights == 'narrow') selected @endif>Narrow</option>
                            <option value="windy" @if ($flag->type_flights == 'windy') selected @endif>Windy</option>
                            <option value="spiral" @if ($flag->type_flights == 'spiral') selected @endif>Spiral</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row address_options" @if (!isset($flag->addresses)) style="display: none" @endif>
                @foreach(explode('--', $flag->addresses) as $i => $address)
                <div class="col-md-6 pl-3 mb-3 input-group @if ($i != 0) additional_addy @endif" @if ($i != 0) id="additional_addy_{{$i}}" @endif>
                    <input type="text" name="addresses[{{$i}}]" id="address_{{$i}}" class="form-control address" placeholder="Address" style="width: 200px" value="{{$address}}" />
                    <input type="number" name="apt[{{$i}}]" id="apt_{{$i}}" class="form-control" placeholder="Apt/Suite Number" value="{{explode(',', $flag->apt)[$i]}}" />
                    <div class="input-group-append">
                        @if ($i == 0)
                        <button type="button" class="btn btn-sm btn-info" id="add_address" value="{{count(explode('--', $flag->addresses))}}" style="width: 100px">Add more</button>
                        @else
                        <button type="button" class="btn btn-sm btn-danger" style="width: 100px" onclick="remove({{$i}})">Remove</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-4 pl-3">
                    <label class="mt-1">Reason</label>
                    <span class="input-group-prepend">
                        <input name="reason_title" type="text" class="form-control form-control-lg" value="{{(isset($flag->reason_title)) ? $flag->reason_title : null}}">
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pl-3">
                    <label class="mt-1">Description</label>
                    <span class="input-group-prepend">
                        <textarea name="description" class="form-control form-control-lg" rows="5">{{(isset($flag->description)) ? $flag->description : null}}</textarea>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <hr>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane"></i></button>
                    <a href="{{route('admin.flag.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
@section('scripts')
<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/form_multiselect.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/inputs/touchspin.min.js')}}"></script>

<script src="{{asset('assets_admin/js/demo_pages/form_input_groups.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
<!-- /theme JS files -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places" type="text/javascript" ></script>

<script>
    jQuery(document).ready(function() {
        $('#num_flights').select2({
            placeholder: "Select a Number",
            allowClear: true
        })
        $('#num_flights').val(null)

        $('#type_flights').select2({
            placeholder: "Select a Type",
            allowClear: true
        })
        $('#type_flights').val(null)

        $('#conditions').change(function() {
            var selected = $(this).val()
            if (selected.includes('zones')) {
                $('#zone_option_box').show()
            } else {
                $('#zone_option_box').hide()
                $('#zones').val(null).trigger('change')
            }

            if (selected.includes('items')) {
                $('.item_options').show()
            } else {
                $('.item_options').hide()
                $('#items').val(null).trigger('change')
                $('#categories').val(null).trigger('change')
            }

            if (selected.includes('flights')) {
                $('.flights_options').show()
            } else {
                $('.flights_options').hide()
                $('#num_flights').val(null).trigger('change')
                $('#type_flights').val(null).trigger('change')
            }

            if (selected.includes('addresses')) {
                $('.address_options').show()
            } else {
                $('.address_options').hide()
                $('#address_0').val(null).trigger('change')
                $('#apt_0').val(null).trigger('change')
                $('.additional_addy').remove()
            }
        })

        $('#add_address').click(function() {
            var i = parseInt($(this).val())
            $(this).val(i + 1)
            var res = '<div class="col-md-6 pl-3 mb-3 input-group additional_addy" id="additional_addy_' + i + '"><input type="text" name="addresses[' + i + ']" id="address_' + i + '" class="form-control address" placeholder="Address" style="width: 200px" /><input type="number" name="apt[' + i + ']" id="apt_' + i + '" class="form-control" placeholder="Apt/Suite Number" value="0" /><div class="input-group-append"><button type="button" class="btn btn-sm btn-danger" style="width: 100px" onclick="remove(' + i + ')">Remove</button></div></div>'

            $('.address_options').append(res)
            var address = new google.maps.places.Autocomplete(document.getElementById('address_' + i))
        })

        var address_0 = new google.maps.places.Autocomplete(document.getElementById('address_0'))
    })

    function remove(i) {
        $('#additional_addy_' + i).remove()
    }
</script>
@endsection