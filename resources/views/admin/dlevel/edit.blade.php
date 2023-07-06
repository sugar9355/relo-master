@extends('admin.layout.base')

@section('title', 'Add Difficulty Level ')

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

    <form class="form-horizontal" action="{{route('admin.dlevel.update', $dlevel->id)}}" method="POST" enctype="multipart/form-data" role="form">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PATCH">
    
    <div class="row">
    
        <div class="col-md-4 pl-3">
                        
            <label class="mt-1">Level Type</label>
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="icon-stack2"></i>&nbsp;&nbsp;Level</span>
                <input name="dlevel" type="text" value="{{explode('-',$dlevel->dlevel)[1]}}" class="form-control form-control-lg touchspin-vertical">
            </span>
            
        </div>
        
        <div class="col-md-4">
        
            <div class="form-group">
                <label for="name" class="col-md-12 col-form-label">Flights</label>
                
                <div class="col-md-12">
                    <select name="stairs[]" class="form-control select" multiple="multiple" data-container-css-class="bg-pink-400">
                        @for ($i = 0; $i <= $max_flights_num; $i++)
                            <option value="{{$i}}" @if(in_array($i,explode(',',$dlevel->stairs))) selected @endif>{{$i}}</option>
                        @endfor
                    </select>
                
                </div>
                
            </div>
        </div>
        </div>
        
        <div class="row">
        
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">Stairs type</label>
                    
                    <div class="col-md-12">
                        <select name="stairs_type[]" class="form-control select" multiple="multiple" data-container-css-class="bg-orange-400">
                            <option value="windy" @if(in_array("windy",explode(',',$dlevel->stairs_type))) selected @endif >Windy</option>
                            <option value="narrow" @if(in_array("narrow",explode(',',$dlevel->stairs_type))) selected @endif>Narrow</option>
                            <option value="wide" @if(in_array("wide",explode(',',$dlevel->stairs_type))) selected @endif>Wide</option>
                            <option value="spiral" @if(in_array("spiral",explode(',',$dlevel->stairs_type))) selected @endif>Spiral</option>
                        </select>
                    
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">Hoisting</label>
                    
                    <div class="col-md-12">
                        <select name="hoisting" class="form-control select" data-container-css-class="bg-success-400">
                            <option value="1" @if($dlevel->hoisting == 1) selected @endif >Yes</option>
                            <option value="0" @if($dlevel->hoisting == 0) selected @endif >No</option>
                        </select>
                    
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
                            <label for="">Min(Weight)</label>
                            <input class="form-control" type="number" id="wei_min" name="wei_min" value="{{$dlevel->wei_min}}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="">Max(Weight)</label>
                            <input class="form-control" type="number" id="wei_max" name="wei_max" value="{{$dlevel->wei_max}}">
                        </div>
                    </div>
                </div>
                <label class="mt-1">Weight</label>
                
                <div class="row">
                
                <table>
                <tr>
                    <td colspan="10">
                        <div id="wei_slider" class="slider" style="width:500px;"></div>
                    </td>
                </tr>
                <tr id="wei_values">
                    @for($i=0;$i<=100;$i += 10)
                        <td style="width:30px;">{{$i}}</td>
                    @endfor
                </tr>
                </table>
                
                <input id="weight" name="weight" type="hidden" value="" >
                
                </div>    
            
        </div>
            
        </div>
    </div>
    
    <div class="row ">
        <div class="col-md-8">
        <div class="form-group">
        
            <label for="name" class="col-md-12 col-form-label">Disassembly</label>
            
            <div class="col-md-12">
            @php $s_ranking = explode(',',$dlevel->ranking); @endphp
                <select name="ranking[]" multiple="multiple" class="form-control select" data-placeholder="Select a Ranking..." data-container-css-class="bg-teal-400">
                    @foreach($ranking as $rank)
                        <option value="{{$rank->ranking_id}}" @if(in_array($rank->ranking_id,$s_ranking)) selected @endif>{{$rank->ranking_name}}</option>
                    @endforeach
                    
                </select>
            
            </div>
        </div>
    </div>    

    
    </div>
    <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="name" class="col-md-12 col-form-label">Elevator</label>

                <select name="elevator[]" class="form-control select" multiple="multiple" data-container-css-class="bg-blue-400">
                    <option value="passanger" @foreach(explode(',',$dlevel->elevator) as $e) @if($e == "passanger") selected @endif @endforeach >Passanger</option>
                    <option value="reserved_freight" @foreach(explode(',',$dlevel->elevator) as $e) @if($e == "reserved_freight") selected @endif @endforeach>Reserved Freight</option>
                    <option value="freight" @foreach(explode(',',$dlevel->elevator) as $e) @if($e == "freight") selected @endif @endforeach>Freight</option>
                </select>
            
            
        </div>
    </div>
    <div class="col-md-4">    
        <div class="form-group">
            <label for="name" class="col-md-12 col-form-label">Category</label>
                <select name="category[]" class="form-control select" data-container-css-class="bg-teal-400" multiple>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"@if(in_array($category->id, explode(',',$dlevel->category))) selected @endif >{{$category->name}}</option>
                    @endforeach
                    
                </select>
            
        </div>
    </div>
    
    </div>
    
    {{-- Additional fields for ground floor, bulkhead, entrance steps --}}
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="groundfloor" class="text-teal-300">Ground Floor</label>
                <select name="groundfloor[]" id="groundfloor" class="form-control select" data-container-css-class="bg-teal-300" multiple>
                    <option value="1to3"@if(in_array('1to3', explode(',',$dlevel->groundfloor))) selected @endif>1 To 3</option>
                    <option value="4to5"@if(in_array('4to5', explode(',',$dlevel->groundfloor))) selected @endif>4 To 5</option>
                    <option value="8to12"@if(in_array('8to12', explode(',',$dlevel->groundfloor))) selected @endif>8 To 12</option>
                </select>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="bulkhead" class="text-primary-400">Bulkhead</label>
                <select name="bulkhead[]" id="bulkhead" class="form-control select" data-container-css-class="bg-primary-400" multiple>
                    <option value="1to3"@if(in_array('1to3', explode(',',$dlevel->bulkhead))) selected @endif>1 To 3</option>
                    <option value="4to5"@if(in_array('4to5', explode(',',$dlevel->bulkhead))) selected @endif>4 To 5</option>
                    <option value="8to12"@if(in_array('8to12', explode(',',$dlevel->bulkhead))) selected @endif>8 To 12</option>
                </select>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="entrance" class="text-orange-400">Entrance Steps</label>
                <select name="entrance[]" id="entrance" class="form-control select" data-container-css-class="bg-orange-400" multiple>
                    <option value="1to3"@if(in_array('1to3', explode(',',$dlevel->entrance))) selected @endif>1 To 3</option>
                    <option value="4to5"@if(in_array('4to5', explode(',',$dlevel->entrance))) selected @endif>4 To 5</option>
                    <option value="8to12"@if(in_array('8to12', explode(',',$dlevel->entrance))) selected @endif>8 To 12</option>
                </select>
            </div>
        </div>
    </div>

    <hr>

    <!-- Optgroups, filtering and select all -->
    <div class="form-group">
        <label class="col-md-12" >Inventory Items</label>
        <div class="col-md-10 pr-1">
            <div class="input-group">@php $s_items = explode(',',$dlevel->items);@endphp
                <select  name="items[]" class="form-control multiselect-display-values multiselect-select-all-filtering" 
                multiple="multiple" data-fouc>
                    @foreach( $items as $item)
                    <option value="{{ $item->name }}" @if(in_array($item->name,$s_items)) selected @endif >{{ $item->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-light multiselect-display-values-select">Select</button>
                    <button type="button" class="btn btn-light multiselect-display-values-deselect">Deselect</button>
                </div>
            </div>    
            <div class="values-area mt-2"></div>
        </div>
    </div>
    
    <div class="form-group">
        <hr>
        <div class="col-md-10">
            <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane"></i></button>
            <a href="{{route('admin.dlevel.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
        </div>
    </div>
</form>

</div>
</div>

@endsection
@section('scripts')
<script>
    set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')

    $("#wei_slider").slider({
    tooltip: 'always',
    range: true,
    min: parseInt($('#wei_min').val()),
    max: parseInt($('#wei_max').val()),
    // step: 10,
    @if(isset($dlevel->weight) && !empty($dlevel->weight))
    values : ["{{explode('-',$dlevel->weight)[0]}}", "{{explode('-',$dlevel->weight)[1]}}"],
    @endif
    
    slide: function (e, ui) 
    {
        $("#weight").val(ui.values[0] +"-"+ ui.values[1]);
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
