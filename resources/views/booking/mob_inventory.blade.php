@extends('user.layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section("styles")
<link rel="stylesheet" href="{{asset('asset/css/mob_inventory.css')}}">
<script src="https://kit.fontawesome.com/7a8a769514.js" crossorigin="anonymous"></script>
<style>
    .active32 {
        border-radius: 0px 0px 0px 0px;
        -moz-border-radius: 0px 0px 0px 0px;
        -webkit-border-radius: 0px 0px 0px 0px;
        background-color:none;
        transition: 0.3s;
        z-index: 1;
        -webkit-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
        -moz-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
        box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
    }

    .div-color1 {
        background-color: #ffc107;
        border-radius: 5px;
        padding-bottom: 10px;
        padding-top: 10px;
        color: white;
        font-weight: 600;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<style>
    .list-group .list-group-item:before{
        background-color: var(--dark);
    }
    .animated {
        -webkit-animation-fill-mode: inherit;
        animation-fill-mode: inherit;
    }
    .progress {
        background-color: #c6d2de;
    }
    ul.ui-autocomplete {
        list-style: none;
        background-color: #fff;
        border: #000 solid 2px;
        width: 200px;
    }

    .nav-buttons {
        width: 100%;
        display: block;
        min-height: 56px;
        line-height: 56px;
        margin-bottom: 1em;
    }
    img.card-img {
        width: auto;
    }

    .simple-pagination ul {
        margin: 0 0 20px;
        padding: 0;
        list-style: none;
        text-align: center;
    }

    .simple-pagination li {
        display: inline-block;
        margin-right: 5px;
    }

    .simple-pagination li a,
    .simple-pagination li span {
        color: #666;
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #EEE;
        background-color: #FFF;
        box-shadow: 0px 0px 10px 0px #EEE;
    }

    .simple-pagination .current {
        color: #FFF;
        background-color: #FF7182;
        border-color: #FF7182;
    }

    .simple-pagination .prev.current,
    .simple-pagination .next.current {
        background: #e04e60;
    }
</style>

<div class="container my-5"> 

    @if($errors->any())
            <div class="card">
            <div class="card-body">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>
            </div>
    @endif


    <div class="row">
        <div class="col-lg-3">
            <!-- menus and filters-->
            <div class="card card-default sidebar-menu">
              <div class="card-heading">
  
                <h5 class="card-title mb-1">Select Preset</h5>
                  
              <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
                 <option data-select2-id="3">Select</option> 
                 <option>Option</option> 
              
              </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 391px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-tfgq-container"><span class="select2-selection__rendered" id="select2-tfgq-container" role="textbox" aria-readonly="true" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>
  
              <div class="card-body">
                <ul class="nav nav-pills flex-column category-menu">
              
                  <li><a href="#" class="nav-link d-flex align-items-center justify-content-between">Preset<span class="badge badge-secondary pull-right">85</span></a>
                    <ul>
                      <li> <a href="#">Large Items</a></li>
                       <li> <a href="#">Office Items</a></li>
                        <li> <a href="#">Coffee Shop Items <span class="badge badge-secondary pull-right">25</span></a></li>
                    
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
              <div class="card card-default sidebar-menu">
              <div class="card-heading">
  
                <h5 class="card-title mb-1">Search Items</h5>
                  
             <input type="text" class="form-control select2" name="" data-select2-id="4">
              </div>
              
              <div class="card-body">
                <ul class="nav nav-pills flex-column category-menu">
              
                  <li><a href="#" class="nav-link d-flex align-items-center justify-content-between">Items</a>
                    <ul>
                      <li> <a href="#">Large Items</a></li>
                       <li> <a href="#">Office Items</a></li>
                        <li> <a href="#">Coffee Shop Items <span class="badge badge-secondary pull-right">25</span></a></li>
                    
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          
          
            <!-- /menus and filters-->
            <div class="banner"><a href="#"><img src="img/banner.jpg" alt="" class="img-fluid"></a></div>
          </div>
        <div class="card-body"> 
         <ul class="nav nav-pills flex-column category-menu">
            
                <li><a href="#" class="nav-link d-flex align-items-center justify-content-between">Preset</a>
                  <ul>  
            @include('booking.inventory.mob_select_category')
              </ul>
                </li>
              </ul>
        </div>

            
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Add Inventory Items</h6>
                        @include('booking.inventory.mob_create_item')
                </div>
                
                <div class="card-body">
                
                    <!-- Grid -->
                    <div class="row products ">
                        <div class="col-lg-4 col-md-6 "> 
                            @include('booking.inventory.mob_items')
                        </div>
                        <div class="col-lg-4 col-md-6" id="inventory-item-mob-container">
                    </div>
                    @if ($preset_show)
                    <div class="row" style="float: right; padding-right: 20px;">
                        <button class="btn btn-info" id="select_preset_items" onclick="add_preset({{$items}})">Add to Cart</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @php $limit_execeed = false; @endphp

    <div id="selected_items" class="row">
        @include('booking.inventory.mob_selected_items')
    </div>

    <div class="col-md-12 mt-3">
        <hr>
        @include('booking.inventory.accuracy')

        <div class="col-md-12 text-center mt-5">
            <a href="/booking/{{ ($booking->booking_id) ?: null }}/4" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark nav-buttons hvr-icon-wobble-horizontal" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
            <a href="#accuracy-box" type="button" class="btn btn-dark nav-buttons hvr-icon-wobble-horizontal" id="open-accuracy" onclick="open_accuracy()"><i class="fas fa-save hvr-icon"></i> Save</a>
            {{-- <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" class="btn nav-buttons btn-dark hvr-icon-wobble-horizontal">Save & Continue  <i class="fas fa-chevron-right hvr-icon"></i></button> --}}

        </div>

    </div>

    <!-- Modal -->
    <div id="preset_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="frm_add_preset" action="/add_preset/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @foreach ($items as $item)
                    <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                    <input type="hidden" name="item_name[{{$item->id}}]" value="{{ $item->name }}">
                    <input type="hidden" name="item_image[{{$item->id}}]" value="{{ $item->image }}">
                    <input type="hidden" name="file_path[{{$item->id}}]" value="{{ $item->file_path }}">
                    @endforeach

                    <div class="modal-header text-white bg-info">
                        <h3 class="m-0">Selected Preset</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        @foreach ($items as $item)
                        <div class="row mb-3 ml-1 mr-1" style="border-bottom: 3px solid #9e9e9e6b">
                            <div class="col-2" style="display: flex; align-items: center; justify-content: center;">
                                <div class="text-center" style="padding: 2px; border: 2px solid #9e9e9e6b; border-radius: 3px;">
                                    <img src="{{$item->file_path}}" alt="inventory item" style="height: 80px; width: 80px">
                                </div>
                            </div>

                            <div class="col-10">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" style="@if (!isset($R[$item->id]))display: none @endif">
                                            <label for="" class="form-label" style="font-size: 12px;">What needs to be disassembled/reassembled?</label>
                                            @if(!empty($ranking))
                                            <select name="ranking[{{$item->id}}]" class="form-control">
                                                <option value="" disabled selected> Select</option>
                                                @foreach($ranking as $rank)
                                                <option value="{{$rank->ranking_id}}">{{$rank->alphabet}} - {{$rank->ranking_name}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="" style="font-size: 12px;">Quantity</label>
                                            @php
                                                $quantity = isset($item->preset_quantity) ? $item->preset_quantity : 1;
                                            @endphp
                                            <!-- <input type="number" name="quantity[{{$item->id}}]" id="quantity" class="form-control" value="{{$quantity}}"> -->
                                            <div class="col-12" style="border: 1px solid #cfcfcf;white-space: nowrap;display: inline-flex;align-items: center; justify-content: space-between;margin: 20px 0 20px 10px;">
                    
                    <input type="button" class="product-subtractt sub" value="-" onclick="decreases('{{$item->id}}','quantitys_')" style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px;">

                    <input style="border:none; outline:none; font-size:20px; color:grey; text-align:center;" type="text" id="quantitys_{{$item->id}}" name="quantity[{{$item->id}}]" value="1" size="1">

                    <input class="product-pluss add" type="button" value="+" onclick="increases('{{$item->id}}','quantitys_')" style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px">

                </div>
                                            </div>
                                    </div>
                                </div>

                                <div class="row mb-3" style="border-bottom: 1px solid #9e9e9e6b">
                                    <div class="col-6">
                                        <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                                            <label class="form-label" style="font-size: 12px;">Pickup Location of Seleted item</label>
                                            @if(!empty($booking_location))
                                            <select name="pick_up_loc_id[{{$item->id}}]" class="form-control" required>
                                            @foreach($booking_location as $k => $loc)
                                            @if ($k != count($booking_location) - 1)
                                                <option value="{{$loc->booking_loc_id}}" @if ($k == 0) selected @endif>{{$loc->location}}</option>
                                            @endif
                                            @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                                            <label class="form-label" style="font-size: 12px;">Drop off Location of Seleted item</label>
                                            @if(!empty($booking_location))
                                            <select name="drop_off_loc_id[{{$item->id}}]" class="form-control" required>
                                            @foreach($booking_location as $k => $loc)
                                            @if ($k != 0)
                                                <option value="{{$loc->booking_loc_id}}" @if ($k == count($booking_location) - 1) selected @endif>{{$loc->location}}</option>
                                            @endif
                                            @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    @if(!empty($item->question))
                                    @foreach(json_decode($item->question) as $q)
                                    @if ($q->allow)
                                    <div class="form-group col-md-6">	
                                        <p style="font-size: 12px;"><strong>Q). {{$q->title}} </strong></p>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="answer[{{$q->id}}]-yes" name="answer[{{$item->id}}][{{$q->id}}]" class="custom-control-input">
                                            <label class="custom-control-label" for="answer[{{$q->id}}]-yes">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="answer[{{$q->id}}]-no" name="answer[{{$item->id}}][{{$q->id}}]" class="custom-control-input">
                                            <label class="custom-control-label" for="answer[{{$q->id}}]-no">No</label>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" name="btn_submit" onclick="select_preset();" data-dismiss="modal">Add Item</button>
                        <button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade " id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="background: #000000aa">
        <div class=" modal-dialog modal-full-height modal-right modal-notify modal-info drop" role="document">
            <div class="modal-content ">
                <!--Header-->
                <div class="modal-header bg-warning text-light">
                    ...
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">×</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <hr>
                        <!-- Radio -->
                        <p class="text-center"></p>
                        <div class="form-check mb-4 div-color1" id="survival_box" onclick="select_kit('survival')">
                            <label class="form-check-label ml-2" for="radio-179">Survival Kit: 1 blow up mattress, 1 blow up couch, </br>1 toiletries kit (${{isset($survival_kit) ? $survival_kit : 0}})</label>
                        </div>
                        <div class="form-check mb-4 div-color1" id="supplies_box" onclick="select_kit('supplies')">
                            <label class="form-check-label ml-2" for="radio-279">Supplies Kit: Based on your inventory size (${{isset($supplies_kit) ? $supplies_kit : 0}})</label>
                        </div>
                    </div>  
                    <!-- Radio -->
                </div>
                <!--Footer-->
                <div style="border-top: 1px solid #dee2e6; " class="modal-footer justify-content-center">
                    <form action="/booking/{{ ($booking->booking_id) ?: null }}/6" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="kit" id="kit" />
                        <button type="submit" name="btn_kit_check" value="1" class="btn bg-warning dvvv drop-btn">Get it now <i class="far fa-gem ml-1 text-white"></i></button>
                        <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" type="button" class="btn btn-outline-success dvvv drop-btn">No, thanks</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
{{-- <script src="{{asset('asset/js/inventory_slide.js')}}"></script> --}}
<script src="{{asset('asset/booking/inventory.js')}}"></script>
<script src="{{asset('switchery-master/dist/switchery.min.js')}}"></script>
<script>
    var booking_id = '{{$booking->booking_id}}'
    var pick_up_loc_id = '{{$booking_location[0]->booking_loc_id}}'
    var drop_off_loc_id = '{{$booking_location[1]->booking_loc_id}}'
    function add_preset(items) {
        if (items.length == 1) {
            $('#item_add_' + items[0].id).modal('show')
        } else if (items.length > 2) {
            $('#preset_modal').modal('show')
        }
    }

    function select_preset() {
        var post_data = $('#frm_add_preset').serializeArray()
        var form_url = $('#frm_add_preset').attr('action')
        $.ajax({
            url: form_url,
            type: "POST",
            data: post_data,
            success: function(data) {
                $('#selected_items').empty()
                $('#selected_items').append(data)
            }
        })
    }

    function increase(item_id) {
        if (parseInt($('#quantity_' + item_id).val()) < 100)
            $('#quantity_' + item_id).val(parseInt($('#quantity_' + item_id).val()) + 1);
    }

    function decrease(item_id) {
        if (parseInt($('#quantity_' + item_id).val()) > 1)
            $('#quantity_' + item_id).val(parseInt($('#quantity_' + item_id).val()) - 1);
    }

    
    function increases(item_id,ids) {
        if (parseInt($('#'+ids+ item_id).val()) < 100)
            $('#'+ids+ item_id).val(parseInt($('#'+ids+ item_id).val()) + 1);
    }

    function decreases(item_id,ids) {
        if (parseInt($('#'+ids+ item_id).val()) > 1)
            $('#'+ids+ item_id).val(parseInt($('#'+ids+item_id).val()) - 1);
    }

    function open_accuracy() {
        $('#accuracy-box').fadeIn();
    }

    function select_kit(kit_kind) {
        $('.div-color1').removeClass('active32');
        $('#'+kit_kind+'_box').addClass('active32');
        $('#kit').val(kit_kind);
    }
    function deleteItem(itemid){
        $('#itemList'+itemid).remove();
        $('#itemListModel'+itemid).remove();
        $('#item_id'+itemid).remove();
        $('#item_name'+itemid).remove();
        $('#item_image'+itemid).remove();
        $('#file_path'+itemid).remove();
        // $('#itemListModel'+itemid).remove();
        // $('#itemListModel'+itemid).remove();
        



    }
</script>
