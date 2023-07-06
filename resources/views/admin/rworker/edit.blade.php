@extends('admin.layout.base')

@section('title', 'Update Recommended Workers ')

@section('content')


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


<div class="card">
    <div class="card-header bg-dark">
        <h5 class="card-title">Difficulty</h5>
    </div>
    <div class="card-body">

        <form class="form-horizontal" action="{{route('admin.rworker.update', $rworker->id)}}" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-4 pl-3">
                    <label class="mt-1">Number of Crews</label>
                    <span class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-stack2"></i>&nbsp;&nbsp;Number</span>
                        <input name="num_crews" type="text" value="{{$rworker->num_crews}}" class="form-control form-control-lg touchspin-vertical">
                    </span>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-8">
                    <div class="form-group pl-2">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min(Weight)</label>
                                    <input class="form-control" type="number" id="wei_min" name="wei_min" value="{{$rworker->wei_min}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max(Weight)</label>
                                    <input class="form-control" type="number" id="wei_max" name="wei_max" value="{{$rworker->wei_max}}">
                                </div>
                            </div>
                        </div>
                        <label class="mt-1">Weight</label>
                        <div class="row">
                            <table>
                                <tr>
                                    <td colspan="10">
                                        <div id="wei_slider" class="slider" style="width: 600px;"></div>
                                    </td>
                                </tr>
                                <tr id="wei_values">
                                    @for($i = 0; $i <= 100; $i += 10)
                                        <td style="width:30px;">{{$i}}</td>
                                    @endfor
                                </tr>
                            </table>
                            <input id="weight" name="weight" type="hidden" value="{{$rworker->weight}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-8">
                    <div class="form-group pl-2">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min(Volume)</label>
                                    <input class="form-control" type="number" id="vol_min" name="vol_min" value="{{$rworker->vol_min}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max(Volume)</label>
                                    <input class="form-control" type="number" id="vol_max" name="vol_max" value="{{$rworker->vol_max}}">
                                </div>
                            </div>
                        </div>
                        <label class="mt-1">Volume</label>
                        <div class="row">
                            <table>
                                <tr>
                                    <td colspan="10">
                                        <div id="vol_slider" class="slider" style="width: 600px;"></div>
                                    </td>
                                </tr>
                                <tr id="vol_values">
                                    @for($i = 0; $i <= 1000; $i += 100)
                                        <td style="width: 30px;">{{$i}}</td>
                                    @endfor
                                </tr>
                            </table>
                            <input id="volume" name="volume" type="hidden" value="{{$rworker->volume}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Category</label>
                        <select name="categories[]" class="form-control select" data-container-css-class="bg-teal-400" multiple="multiple">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" @if(in_array($category->id, explode(',', $rworker->categories))) selected @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Optgroups, filtering and select all -->
            <div class="form-group">
                <label class="col-md-12">Inventory Items</label>
                <div class="col-md-10 pr-1">
                    <div class="input-group">@php $s_items = explode(',',$rworker->items);@endphp
                        <select name="items[]"
                            class="form-control multiselect-display-values multiselect-select-all-filtering"
                            multiple="multiple" data-fouc>
                            @foreach( $items as $item)
                            <option value="{{ $item->name }}" @if(in_array($item->name, $s_items)) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button"
                                class="btn btn-light multiselect-display-values-select">Select</button>
                            <button type="button"
                                class="btn btn-light multiselect-display-values-deselect">Deselect</button>
                        </div>
                    </div>
                    <div class="values-area mt-2"></div>
                </div>
            </div>

            <div class="form-group">
                <hr>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane"></i></button>
                    <a href="{{route('admin.rworker.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
@section('scripts')
<script>
    set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')

    set_values(parseInt($('#vol_min').val()), parseInt($('#vol_max').val()), '#vol_values')

    $("#wei_slider").slider({
        tooltip: 'always',
        range: true,
        min: parseInt($('#wei_min').val()),
        max: parseInt($('#wei_max').val()),
        // step: 10,
        @if(isset($rworker->weight) && !empty($rworker->weight))
        values : [{{explode('-',$rworker->weight)[0]}}, {{explode('-',$rworker->weight)[1]}}],
        @endif
        
        slide: function (e, ui) 
        {
            $("#weight").val(ui.values[0] +"-"+ ui.values[1]);
        }
    });
    $("#vol_slider").slider({
        tooltip: 'always',
        range: true,
        min: parseInt($('#vol_min').val()),
        max: parseInt($('#vol_max').val()),
        // step: 100,
        @if(isset($rworker->volume) && !empty($rworker->volume))
        values : [{{explode('-',$rworker->volume)[0]}}, {{explode('-',$rworker->volume)[1]}}],
        @endif
        
        slide: function (e, ui) 
        {
            $("#volume").val(ui.values[0] +"-"+ ui.values[1]);
        }
    });

    $('#wei_min').keyup(function() {
        $("#wei_slider").slider("option", "min", parseInt($('#wei_min').val()));
        set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')
    })

    $('#wei_max').keyup(function() {
        $("#wei_slider").slider("option", "max", parseInt($('#wei_max').val()));
        set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')
    })


    $('#vol_min').keyup(function() {
        $("#vol_slider").slider("option", "min", parseInt($('#vol_min').val()));
        set_values(parseInt($('#vol_min').val()), parseInt($('#vol_max').val()), '#vol_values')
    })

    $('#vol_max').keyup(function() {
        $("#vol_slider").slider("option", "max", parseInt($('#vol_max').val()));
        set_values(parseInt($('#vol_min').val()), parseInt($('#vol_max').val()), '#vol_values')
    })

    function set_values(min, max, id) {
        $(id).empty()
        for (var i = min;;i += (max-min)/10) {
            if (i >= max) {
                $(id).append('<td style="width: 30px;">' + max + '</td>')
                break;
            } else if (i.toFixed(0) < max) {
                $(id).append('<td style="width: 30px;">' + i.toFixed(0) + '</td>')
            }
        }
    }
</script>
@endsection