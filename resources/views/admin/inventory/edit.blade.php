@extends('admin.layout.base')
@section('title', 'Update Inventory Items')

<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/media/fancybox.min.js')}}"></script>

<script src="{{asset('assets_admin/js/demo_pages/blog_single.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/dropzone.min.js')}}"></script>
<style>
    #div_n_w .row .col {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-box {
        display: flex;
        align-items: flex-end;
    }
</style>

@section('content')

<form class="form-horizontal" action="{{route('admin.inventory.update',$inventory->id)}}" method="POST" enctype="multipart/form-data" role="form">
                    
        {{csrf_field()}}
        
        <input type="hidden" name="_method" value="PATCH">

<div class="row">
    <div class="col-md-9">
        <div class="card">
        
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
                    <div class="col-md-6">                
                        <div class="form-group">
                            <label for="name" class="col-form-label">Item Category Name</label>
                            <select class="form-control" name="category" id="category" onchange="showCategoryflights();">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $inventory->category_id)) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-4">                
                        <div class="form-group">
                            <label for="name" class="col-form-label">Select Material</label>
                            <select class="form-control" name="meterial" id="meterial_type">
                                <option value="" selected hidden>Select Category</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" @if($material->id == $inventory->meterial)) selected @endif >{{ $material->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-2">                
                        <div class="form-group">
                            <label for="name" class="col-form-label">Select Hoisting</label>
                            <div class="form-check form-check-switch form-check-switch-left">
                                <label class="form-check-label d-flex align-items-center">
                                    <input name="hoisting" type="checkbox" value="1" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" @if($inventory->hoisting == 1) checked @endif>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Inventroy Item Name</label>
                            <input class="form-control" type="text" value="{{ $inventory->name }}" name="name" required id="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-6">                
                        <div class="form-group">
                        @php $inventory_equipment = explode(',',$inventory->equipments) @endphp
                            <label for="name" class="col-form-label">Equipment Required</label>
                            <select name="equipment[]" id="equipment" multiple="multiple" class="form-control select" data-fouc>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}" @if(in_array($equipment->id,$inventory_equipment)) selected @endif >{{ $equipment->name }}</option>
                                @endforeach
                            </select>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-12">                
                        <div class="form-group">
                        
                            <label>Badges Assignment:</label>
                            <select name="badges[]" multiple="multiple" class="form-control select" data-container-css-class="bg-teal-400" placeholder="select badges" data-fouc>
                            @foreach($types as $type)
                                <optgroup label="{{$type['type']}}">
                                    @foreach($type['badge'] as $b)    
                                        <option value="{{$b['id']}}" @if(in_array($b["id"],explode(',',$inventory->badges))) selected @endif>{{$b['name']}}</option>
                                    @endforeach    
                                </optgroup>
                            @endforeach    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flag" class="col-md-12 col-form-label">@lang('admin.flag')</label>
                            @foreach ($flags as $flag)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flag" id="flag_{{$flag->id}}" value="{{$flag->id}}" @if ($flag->id == $inventory->flag) checked @endif>
                                    <label class="form-check-label" style="color: {{$flag->color}}"><i class="icon-flag7"></i></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                        {{-- Stackable / Unstackable setting --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stackable" class="col-form-label">Stackable</label>
                                <div class="form-check form-check-switch form-check-switch-left">
                                    <label class="form-check-label d-flex align-items-center">
                                        <input name="stackable" type="checkbox" value="1" id="stackable"
                                            class="form-check-input form-check-input-switch" data-on-text="Stackable"
                                            data-off-text="Unstackable" data-on-color="success" data-off-color="default" @if($inventory->stackable == 1)checked @endif/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group stackable_mul_container" @if($inventory->stackable != 1)style="display: none" @endif>
                                <label for="stackable_multiplier">Multiplier</label>
                                <input type="number" class="form-control col-md-6" name="stackable_multiplier" id="stackable_multiplier" step="0.01"
                                    value="{{isset($inventory->stackable_multiplier) ? $inventory->stackable_multiplier : 1}}" />
                            </div>
                        </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <!-- Photos from Flickr -->
        <div class="card-img-actions" >
        @if($inventory->file_path == '')
            <a href="/no_item.jpg" data-popup="lightbox"><img class="card-img img-fluid"   src="/no_item.jpg" alt=""><span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span></a>
        @else
            <a href="{{$inventory->file_path}}" data-popup="lightbox"><img class="card-img img-fluid" src="{{$inventory->file_path}}" alt=""><span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span></a>
        @endif
        </div>
        <!-- /photos from Flickr -->
        <!-- Seamless button group -->
        <div class="mb-3">
            <div class="row row-tile no-gutters">
                
                <button type="button" class="btn btn-light btn-block btn-float m-0 mb-1" data-toggle="modal" data-target="#upload_picture">
                    <i class="icon-file-picture text-blue-400 icon-2x"></i>
                    <span>Upload</span>
                </button>
            </div>
        </div>
        <!-- /seamless button group -->
    
    </div>
</div>

<div class="card">
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
                    <option value="{{ $material->id }}"@if($material->id == $inventory->wrapping_material)) selected @endif>{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_qty" class="col-form-label">Qty</label>
                <input class="form-control" type="text" name="wrapping_qty" id="wrapping_qty" placeholder="Qty" value="{{$inventory->wrapping_qty}}" />
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_time" class="col-form-label">Time to Wrap</label>
                <input class="form-control" type="text" name="wrapping_time" id="wrapping_time" placeholder="Time to Wrap" value="{{$inventory->wrapping_time}}" />
            </div>
            <div class="form-group col-md-2">
                <label for="wrapping_price" class="col-form-label">Price</label>
                <input class="form-control" type="text" name="wrapping_price" id="wrapping_price" placeholder="Wrapping Price" value="{{$inventory->wrapping_price}}" />
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white header-elements-inline">
        <h6 class="card-title">Insurance</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($ins_categories as $item)
            <div class="form-group col-md-2 text-center">
                <label for="">{{$item->name}}</label>
                <input class="form-control" type="text" name="ins[{{$item->id}}]" id="ins_{{$item->name}}" placeholder="" value="{{isset($ins_data[$item->id]) ? $ins_data[$item->id] : 0}}" />
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
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
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.weight') Min</label>
                <input class="form-control" type="text" name="weight_min" id="weight_min" placeholder="@lang('admin.weight')" value="{{$inventory->weight_min}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.weight') Max</label>
                <input class="form-control" type="text" name="weight_max" id="weight_max" placeholder="@lang('admin.weight')" value="{{$inventory->weight_max}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.price') Min</label>
                <input class="form-control" type="text" name="junk_price_min" id="junk_price_min" placeholder="Junk Price" value="{{$inventory->junk_price_min}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.price') Max</label>
                <input class="form-control" type="text" name="junk_price_max" id="junk_price_max" placeholder="Junk Price" value="{{$inventory->junk_price_max}}" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2 text-center">
                <label for="">Price for Storage</label>
                <input class="form-control" type="text" name="storage_price" id="storage_price" placeholder="Price for storage" value="{{$inventory->storage_price}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">Pickup Override Price</label>
                <input class="form-control" type="text" name="pickup_price" id="pickup_price" placeholder="Price for pickup" value="{{$inventory->pickup_price}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">Dropoff Override Price</label>
                <input class="form-control" type="text" name="dropoff_price" id="dropoff_price" placeholder="Price for dropoff" value="{{$inventory->dropoff_price}}" />
            </div>
    </div>
        <div class="row">
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.width')</label>
                <input class="form-control volume-factor" type="text" name="width" id="width" placeholder="@lang('admin.width')" value="{{$inventory->width}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.height')</label>
                <input class="form-control volume-factor" type="text" name="height" id="height" placeholder="@lang('admin.height')" value="{{$inventory->height}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.breadth')</label>
                <input class="form-control volume-factor" type="text" name="breadth" id="breadth" placeholder="@lang('admin.breadth')" value="{{$inventory->breadth}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.volume')</label>
                <input class="form-control" type="text" name="volume" id="volume" placeholder="@lang('admin.volume')" value="{{$inventory->volume}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.multiplier')</label>
                <input class="form-control" type="text" name="multiplier" id="multiplier" placeholder="@lang('admin.multiplier')" value="{{$inventory->multiplier}}" />
            </div>
            <div class="form-group col-md-2 text-center">
                <label for="">@lang('admin.packing_volume')</label>
                <input class="form-control" type="text" name="packing_volume" id="packing_volume" placeholder="@lang('admin.packing_volume')" value="{{$inventory->packing_volume}}" />
            </div>
        </div>
    </div>
</div>

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
        @include('admin.inventory.includes.time')
    </div>
</div>

    @php $index = 1; @endphp
    @foreach($categories as $category)

    <div id="question_{{$category->id}}" class="card"  @if($category->id != $inventory->category_id) style="display:none;" @endif>
        <div class="card-header bg-dark text-white header-elements-inline">
            <h6 class="card-title">Category Question ( {{$category->name}} )</h6>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
        @foreach($category_questions as $k => $question)
        @if($question->category_id == $category->id)
            
            <!-- Category Question -->
            
            <div class="form-group">
                <div class="row">
                    <div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . ({{$index}}) </label></div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" value="{{$question->title}}" name="category_question[{{$question->question_id}}]" readonly>
                    </div>
                    <div class="col-md-2 form-check form-check-switch form-check-switch-left">
                        <label class="form-check-label d-flex align-items-center">
                            <input name="check_cat_question[{{$question->question_id}}]" type="checkbox" value="1" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" @if($question->allow) checked @endif>
                        </label>
                    </div>
                </div>
            </div>
            @php $index = $index + 1; @endphp
        @endif
        @endforeach
            <!-- Category Question -->
        </div>
    </div>

@endforeach

    <div class="card">
        <div class="card-header bg-dark text-white header-elements-inline">
            <h6 class="card-title">Inventory Questions</h6>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div id="questions" class="card-body">
                @foreach($inventory_questions as $k => $question)
                <div id="div_{{$k+1}}" class="form-group">
                    
                    <div class="row">
                        <div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . ({{$k+1}}) </label></div>
                        <div class="col-md-7">
                            <input class="form-control" type="text" value="{{$question->title}}" name="question[{{$k+1}}]" placeholder="Enter Question text" >
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-switch form-check-switch-left">
                                <label class="form-check-label d-flex align-items-center">
                                    <input name="check_inv_question[{{$k+1}}]" type="checkbox" value="1" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" @if ($question->allow)checked @endif>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if($k == 0)
                                <button id="btn_add" value="{{count($inventory_questions)}}" type="button" class="btn btn-success">Add More</button>
                            @else
                                <button class="btn btn-danger" type="button" onclick="remove_q('{{$k+1}}')">Remove</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    
    <div class="card">
        <div class="card-body">

            <button type="submit" class="btn btn-primary">Update Item  <i class="icon-paperplane"></i> </button>
            <a href="{{route('admin.inventory.index')}}" class="btn btn-default btn-outline-dark">@lang('admin.cancel')</a>

        </div>
    </div>
</form>

<!-- Modal -->
<div id="upload_picture" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Upload Items Picture / Excel</h4>
        <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="close" >&times;</a>
        
      </div>
      <div class="modal-body">
        <!-- Dropzone -->
        
            <form class="dropzone" id="dropzone_single" action="{{route('admin.inventory.update',$inventory->id)}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PATCH">
            </form>
        
        <!-- /dropzone -->
      </div>
      <div class="modal-footer">
        <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="btn btn-default">Done</a>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="sample_download" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Download Excel Sheet</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
    var material_price = 0;
    var wrapping_mat_price = 0;
    var wrapping_qty = 0;
    var charge_cb_ft = parseFloat('{{$charge_cb_ft}}');
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

        $("#btn_add").on('click', function()
        {
            index = $("#btn_add").val();
            index = parseInt(index) + 1;
            var res  = '<div id="div_'+index+'" class="form-group">';
                res += '<div class="row">';
                res += '<div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . ('+index+') </label></div>';
                res += '<div class="col-md-7">';
                res += '<input class="form-control" type="text" value="" name="question['+index+']" id="question_'+index+'" placeholder="Enter Question text">';
                res += '</div><div class="col-md-2">';
                res += '<div class="form-check form-check-switch form-check-switch-left"><label class="form-check-label d-flex align-items-center">';
                res += '<input name="check_inv_question['+index+']" type="checkbox" value="1" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default" checked>';
                res += '</label></div></div><div class="col-md-2">';
                res += '<button class="btn btn-danger" type="button" onclick="remove_q('+index+')">Remove</button>';
                res += '</div></div></div>';
            
            $("#questions").append(res);
            $('.form-check-input-switch').bootstrapSwitch()
            $("#btn_add").val(index);
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
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" />'
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
                    res += '<div class="col-4 form-group btn-box"><button class="form-control btn btn-danger" type="button" onclick="remove_flight(' + (current_flight + 1) + ')">Remove</button></div></div></div>'
                } else if (num_worker == 2) {
                    res = '<div class="col-6 flights-' + num_worker + '-' + (current_flight + 1) + '">'
                    res += '<div class="row"><div class="form-group col-2 text-info text-center"><label>Flights</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" />'
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
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_flight + 1) + '" />'
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
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" readonly />'
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
                    res += '</div>'
                    res += '<div class="col-3 form-group btn-box"><button class="form-control btn btn-danger" type="button" data-target_e_type="' + elevator_type + '" data-target_floor="' + (current_floor + 1) + '" onclick="remove_elevator()">Remove</button></div></div></div>'
                } else if (num_worker == 2) {
                    res = '<div class="col-6 ' + id + '"><div class="row">'
                    res += '<div class="form-group col-2 text-info text-center"><label>Floor</label>'
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" readonly />'
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
                    res += '<input class="form-control text-center text-info" type="text" value="' + (current_floor + 1) + '" readonly />'
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
                $('#flights_min_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_min_1_' + i + '_0').val()) * by).toFixed(5))
                $('#flights_med_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_med_1_' + i + '_0').val()) * by).toFixed(5))
                $('#flights_max_' + num_worker + '_' + i + '_0').val((parseFloat($('#flights_max_1_' + i + '_0').val()) * by).toFixed(5))
                $('#flights_min_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_min_1_' + i + '_1').val()) * by).toFixed(5))
                $('#flights_med_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_med_1_' + i + '_1').val()) * by).toFixed(5))
                $('#flights_max_' + num_worker + '_' + i + '_1').val((parseFloat($('#flights_max_1_' + i + '_1').val()) * by).toFixed(5))
            }

            $('.add-elevator').each(function(index) {
                var type = $(this).data('type')
                var current_floor = parseInt($(this).val())
                for (i = 0; i <= current_floor; i++) {
                    $('#' + type + '_time_' + num_worker + '_' + i + '_0').val((parseFloat($('#' + type + '_time_1_' + i + '_0').val()) * by).toFixed(5))
                    $('#' + type + '_delay_' + num_worker + '_' + i + '_0').val((parseFloat($('#' + type + '_delay_1_' + i + '_0').val()) * by).toFixed(5))
                    $('#' + type + '_time_' + num_worker + '_' + i + '_1').val((parseFloat($('#' + type + '_time_1_' + i + '_1').val()) * by).toFixed(5))
                    $('#' + type + '_delay_' + num_worker + '_' + i + '_1').val((parseFloat($('#' + type + '_delay_1_' + i + '_1').val()) * by).toFixed(5))
                }
            })

            for (j = 0; j < 2; j++) {
                $('#bulkhead_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#bulkhead_time_1_1to3_' + j).val()) * by).toFixed(5))
                $('#bulkhead_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#bulkhead_delay_1_1to3_' + j).val()) * by).toFixed(5))
                $('#bulkhead_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#bulkhead_time_1_4to5_' + j).val()) * by).toFixed(5))
                $('#bulkhead_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#bulkhead_delay_1_4to5_' + j).val()) * by).toFixed(5))
                $('#bulkhead_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#bulkhead_time_1_8to12_' + j).val()) * by).toFixed(5))
                $('#bulkhead_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#bulkhead_delay_1_8to12_' + j).val()) * by).toFixed(5))
                $('#en_steps_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#en_steps_time_1_1to3_' + j).val()) * by).toFixed(5))
                $('#en_steps_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#en_steps_delay_1_1to3_' + j).val()) * by).toFixed(5))
                $('#en_steps_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#en_steps_time_1_4to5_' + j).val()) * by).toFixed(5))
                $('#en_steps_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#en_steps_delay_1_4to5_' + j).val()) * by).toFixed(5))
                $('#en_steps_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#en_steps_time_1_8to12_' + j).val()) * by).toFixed(5))
                $('#en_steps_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#en_steps_delay_1_8to12_' + j).val()) * by).toFixed(5))
                $('#groundfloor_time_' + num_worker + '_1to3_' + j).val((parseFloat($('#groundfloor_time_1_1to3_' + j).val()) * by).toFixed(5))
                $('#groundfloor_delay_' + num_worker + '_1to3_' + j).val((parseFloat($('#groundfloor_delay_1_1to3_' + j).val()) * by).toFixed(5))
                $('#groundfloor_time_' + num_worker + '_4to5_' + j).val((parseFloat($('#groundfloor_time_1_4to5_' + j).val()) * by).toFixed(5))
                $('#groundfloor_delay_' + num_worker + '_4to5_' + j).val((parseFloat($('#groundfloor_delay_1_4to5_' + j).val()) * by).toFixed(5))
                $('#groundfloor_time_' + num_worker + '_8to12_' + j).val((parseFloat($('#groundfloor_time_1_8to12_' + j).val()) * by).toFixed(5))
                $('#groundfloor_delay_' + num_worker + '_8to12_' + j).val((parseFloat($('#groundfloor_delay_1_8to12_' + j).val()) * by).toFixed(5))
            }
        })

        $('#meterial_type').change(function() {
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
    });

    function cal_price_storage() {
        var storage_price = (charge_cb_ft * parseFloat($('#packing_volume').val()) * parseFloat($('#stackable_multiplier').val())).toFixed(5);
        $('#storage_price').val(storage_price);
    }

    function cal_volume() {
        var width = $("#width").val();
        var height = $("#height").val();
        var breadth = $("#breadth").val();
        var multiplier = $("#multiplier").val();
        
        var volume = ((width * height * breadth) / 1728).toFixed(5);
        var p_vol = (multiplier * volume).toFixed(5);
        
        $("#volume").val(volume);
        $('#packing_volume').val(p_vol);
        $('#packing_volume').trigger('keyup');
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
    
    function showCategoryflights()
    {
        $("div[id*='question_']").hide();

        var category_id = $(event.target).val()

        $("#question_" + category_id).fadeIn("slow");
        $("#question_" + category_id).fadeIn(1000);

        $.ajax({
            url: "/admin/format_category/" + category_id,
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
    }

    </script>

@endsection
