@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- card header -->
            <div class="card-header header-elements-inline">
                <h4 class="card-title">
                    Booking Items Information
                </h4>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="btn btn-info" href="{{route('admin.booking_detail', [$booking_id, $date, $date_type])}}"><i class="icon ti-angle-double-left"></i> Go Back</a>
                    </div>
                </div>
            </div>
            <!-- card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- selected items -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Selected Items</h4>
                            </div>
                            <div class="card-body">
                                <div class="row" id="selected_items">
                                    @foreach($selected_items as $s_item)
                                    <div class="col-sm-3 col-md-2 col-lg-2 col-xl-1">
                                        <div id="div_item_{{ $s_item->booking_item_id }}" class="card">

                                            <div class="text-center">
                                                <form id="ajax-form{{ $s_item->booking_item_id }}" action="/admin/items_quantity/{{$booking_id}}" method="POST" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="booking_id" value="{{$booking_id}}">
                                                    <input type="hidden" name="btn_submit" value="5">
                                                    <input type="hidden" name="booking_item_id" value="{{$s_item->booking_item_id}}">
                                                    <input type="hidden" id="quantity{{ $s_item->booking_item_id }}" name="quantity" value="{{$s_item->quantity}}">
                                                    <input type="hidden" id="action{{ $s_item->booking_item_id }}" name="action" value="">
                                                </form>

                                                <div class="col-md-12 text-center">
                                                    <button type="button" class="border-0 bg-white text-success p-0" name="update_quantity" onclick="quantity_update('{{ $s_item->booking_item_id }}','+');"><i class="icon icon-plus2"></i></button>
                                                    <button type="button" class="border-0 bg-white text-success p-0" name="update_quantity" onclick="quantity_update('{{ $s_item->booking_item_id }}','-');"><i class="icon icon-minus2"></i></button>
                                                    <button type="button" class="border-0 bg-white text-danger p-0" data-toggle="modal" data-target="#item_delete{{ $s_item->booking_item_id }}"><i class="icon icon-trash-alt"></i></button>
                                                    <button type="button" class="border-0 bg-white text-info p-0"  data-toggle="modal" data-target="#item_info_{{ $s_item->booking_item_id }}"><i class="icon icon-eye2"></i></button>
                                                </div>
                                            </div>

                                            <div class="card-image text-center">
                                                <img src="{{ $s_item->file_path }}" class="card-img-top" style="height: 80px; width: auto" alt="">
                                            </div>

                                            <p class="text-info text-center" style="margin-bottom: 0">
                                                <span>Quantity:</span>  {{ $s_item->quantity }}
                                            </p>
                                        </div>
                                    </div>
                                    @include('admin.includes.item_delete')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- add items -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Inventory Items</h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center text-warning mb-1">
                                    <div class="col-2"><h4>Categories</h4></div>
                                    <div class="col-10"></div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="nav flex-column nav-pills text-left" id="v-pills-tab-categories" role="tablist" aria-orientation="vertical">
                                            @foreach($categories as $k => $cat_item)
                                            <a class="nav-link @if($k == 0)active @endif text-uppercase" id="v-pills-{{$cat_item->id}}-tab" data-toggle="pill" href="#v-pills-{{$cat_item->id}}" role="tab" aria-controls="v-pills-{{$cat_item->id}}" aria-selected="true">{{$cat_item->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="tab-content" id="v-pills-tabContent-categories">
                                            @foreach($categories as $k => $cat_item)
                                            <div class="tab-pane fade @if($k == 0)show active @endif" id="v-pills-{{$cat_item->id}}" role="tabpanel" aria-labelledby="v-pills-{{$cat_item->id}}-tab">
                                                <div class="row">
                                                    @foreach($inventory_items[$cat_item->id] as $item)
                                                    <div class="col-sm-3 col-md-2 col-xl-2">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
                                                                    <div class="card-image text-center">
                                                                        @if($item->file_path == '')
                                                                        <img src="/no_item.jpg" height="80" alt="">
                                                                        @else
                                                                        <img src="{{$item->file_path}}" height="80" alt="">
                                                                        @endif
                                                                    </div>
                                                                    <hr>
                                                                    <h6 class="text-center text-info mt-3">{{$item->name}}</h6>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @include('admin.includes.add_item')
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function quantity_update(id, action) {
        $('#action' + id).val(action);
        $('#quantity' + id).val();

        var postData = $("#ajax-form" + id).serializeArray();
        var formURL = $("#ajax-form" + id).attr("action");

        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data) {
                $('#selected_items').empty();
                $('#selected_items').append(data);
            }
        })
    }

    function delete_item(booking_id, booking_item_id) {
        $.ajax(
        {
            url : "/admin/delete_item/"+booking_id+"/"+booking_item_id,
            type: "GET",
            success:function(data, textStatus, jqXHR) 
            {
                $("#selected_items").empty();
                $("#selected_items").append(data);
                
            },
        });
        
        return false;
    }

    function add_item(id) {
        var postData = $("#frm_add_items" + id).serializeArray();
        var formURL = $("#frm_add_items" + id).attr("action");
        
        $.ajax({
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR) 
            {
                $("#selected_items").empty();
                $("#selected_items").append(data);
            },
        });

    }

    jQuery(document).ready(function() {

    })
</script>
@endsection