@extends('admin.layout.base')

@section('title', 'Add Item ')

@section('content')

    <div class="card">
        <div class="card-body">
            <div >
                <a href="{{ route('admin.zone_type.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

                <h5 style="margin-bottom: 2em;">Update Zone Type</h5>

                <form class="form-horizontal" action="{{route('admin.zone_type.update', $zoneType->id)}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $zoneType->name }}" name="name" required id="name" placeholder="Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="zip_code" class="col-md-12 col-form-label">@lang('admin.zip_code')</label>
                        <div class="col-md-2 input-group mb-3">
                            <input type="text" class="form-control" value="{{ old('zip_code') }}" placeholder="Zip Code" aria-label="Zip Code" aria-describedby="basic-addon2" maxlength="5" id="zip_code">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="add_zipcode">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <select id="zip_codes" name="zip_code[]" class="form-control select" data-container-css-class="bg-blue-600" multiple>
                                @foreach (explode(',', $zoneType->zip_code) as $item)
                                <option value="{{$item}}" selected>{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="flag" class="col-md-12 col-form-label">@lang('admin.flag')</label>
                            @foreach ($flags as $flag)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flag" id="flag_{{$flag->id}}" value="{{$flag->id}}" @if ($flag->id == $zoneType->flag) checked @endif>
                                    <label class="form-check-label" style="color: {{$flag->color}}"><i class="icon-flag7"></i></label>
                                    </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sh_price" class="col-md-6 col-form-label text-center">Shuffle Price</label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" value="{{ $zoneType->sh_price }}" name="sh_price" id="sh_price" placeholder="Input Amount">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
                        <div class="col-md-1">
                            <input class="form-control" type="color" value="{{ $zoneType->color }}" name="color" required id="color" placeholder="Color" style="height: 40px">
                        </div>
                        <div class="col-md-2">
                            <div id="colorpicker"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <hr>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Zone_Type')</button>
                            <a href="{{route('admin.zone_type.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
                        </div>
                    </div>
                </form>
            </div>
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

<script>
    var zipcodes = $('#zip_codes').val()
    jQuery(document).ready(function() {
        $('#add_zipcode').click(function() {
            if ($('#zip_code').val().length == 5) {
                if (!zipcodes.includes($('#zip_code').val())) {
                    zipcodes.push($('#zip_code').val())
                    var res = '<option value="' + $('#zip_code').val() + '" selected id="id_' + $('#zip_code').val() + '">' + $('#zip_code').val() + '</option>'
                    $('#zip_codes').append(res)
                    $('#zip_code').val(null)
                    $('#zip_code').focus()
                } else {
                    $('#zip_code').val(null)
                    $('#zip_code').focus()
                }
            }
        })

        $('#zip_codes').change(function() {
            var current_zipcodes = $(this).val()
            var removed_zipcodes = arr_diff(zipcodes, current_zipcodes)
            removed_zipcodes.map(function(zipcode) {
                $('#id_' + zipcode).remove()
            })
        })
    })

    function arr_diff (a1, a2) {
        var a = [], diff = [];
        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }
        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }
        for (var k in a) {
            diff.push(k);
        }
        return diff;
    }
</script>
@endsection
