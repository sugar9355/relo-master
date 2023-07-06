@extends('user.layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section("styles")
<link rel="stylesheet" href="{{asset('switchery-master/dist/switchery.min.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<style>
    .bg-warning {
        background-color: #FFC81C!important;
    }
    .yellow-bg {
        background-color: #FFDE50!important;
        color: white;
    }

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
        border: 1px solid #bbbbbb;
        background-color: white;
        border-radius: 5px;
        padding-bottom: 10px;
        padding-top: 10px;
        color: #212529;
        font-weight: 600;
        margin-bottom: 15px;
    }
    input[type="file"] {
        display: none;
    }

    img {
        cursor: pointer;
    }

    .cen {
        margin: auto;
        padding: 10px;
    }

    .itemee:checked {
        background-color: #ffdb71;
    }

    .YellBack {
        background-color: #ffdb71;
    }

    .boxes-bulk1 {
        background-color: #F5F5F5;
    }

    .border-right {
        border-color: grey;
    }

    .nopad {
        padding-right: 0px;
        padding-left: 0px;
    }

    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #ffdb71;
        border: 1px solid rgb(109, 109, 109) !important;
        -webkit-box-shadow: 7px 13px 25px -12px rgba(150, 150, 150, 1);
        -moz-box-shadow: 7px 13px 25px -12px rgba(150, 150, 150, 1);
        box-shadow: 7px 13px 25px -12px rgba(150, 150, 150, 1);


    }

    .pure-material-textfield-filled {
        position: relative;
        display: inline-block;
        font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
        font-size: 16px;
        line-height: 1.5;
        overflow: hidden;
    }

    /* Input, Textarea */
    .pure-material-textfield-filled>input,
    .pure-material-textfield-filled>textarea {
        display: block;
        box-sizing: border-box;
        margin: 0;
        border: none;
        border-top: solid 27px transparent;
        border-bottom: solid 1px rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
        border-radius: 4px 4px 0 0;
        padding: 0 12px 10px;
        width: 100%;
        height: inherit;
        color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
        background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.04);
        box-shadow: none;
        /* Firefox */
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        caret-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        transition: border-bottom 0.2s, background-color 0.2s;
    }

    /* Span */
    .pure-material-textfield-filled>input+span,
    .pure-material-textfield-filled>textarea+span {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: block;
        box-sizing: border-box;
        padding: 7px 12px 0;
        color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
        font-size: 75%;
        line-height: 18px;
        pointer-events: none;
        transition: color 0.2s, font-size 0.2s, line-height 0.2s;
    }

    /* Underline */
    .pure-material-textfield-filled>input+span::after,
    .pure-material-textfield-filled>textarea+span::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        display: block;
        width: 100%;
        height: 2px;
        background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        transform-origin: bottom center;
        transform: scaleX(0);
        transition: transform 0.3s;
    }

    /* Hover */
    .pure-material-textfield-filled>input:hover,
    .pure-material-textfield-filled>textarea:hover {
        border-bottom-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
        background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.08);
    }

    /* Placeholder-shown */
    .pure-material-textfield-filled>input:not(:focus):placeholder-shown+span,
    .pure-material-textfield-filled>textarea:not(:focus):placeholder-shown+span {
        font-size: inherit;
        line-height: 48px;
    }

    /* Focus */
    .pure-material-textfield-filled>input:focus,
    .pure-material-textfield-filled>textarea:focus {
        outline: none;
    }

    .pure-material-textfield-filled>input:focus+span,
    .pure-material-textfield-filled>textarea:focus+span {
        color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    }

    .pure-material-textfield-filled>input:focus+span::before,
    .pure-material-textfield-filled>textarea:focus+span::before {
        opacity: 0.12;
    }

    .pure-material-textfield-filled>input:focus+span::after,
    .pure-material-textfield-filled>textarea:focus+span::after {
        transform: scale(1);
    }

    /* Disabled */
    .pure-material-textfield-filled>input:disabled,
    .pure-material-textfield-filled>textarea:disabled {
        border-bottom-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
        color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
        background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.24);
    }

    .pure-material-textfield-filled>input:disabled+span,
    .pure-material-textfield-filled>textarea:disabled+span {
        color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
    }

    /* Faster transition in Safari for less noticable fractional font-size issue */
    @media not all and (min-resolution:.001dpcm) {
        @supports (-webkit-appearance:none) {

            .pure-material-textfield-filled>input,
            .pure-material-textfield-filled>input+span,
            .pure-material-textfield-filled>input+span::after,
            .pure-material-textfield-filled>textarea,
            .pure-material-textfield-filled>textarea+span,
            .pure-material-textfield-filled>textarea+span::after {
                transition-duration: 0.1s;
            }
        }
    }

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
</style>
<link rel="stylesheet" href="{{asset('asset/notiflix/notiflix-2.3.1.min.css')}}">

@endsection

@section('content')
<div class="container my-5"> 

    @if($errors->any())
        <div class="card">
            <div class="card-body">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col-md-3 pr-0">
            @include('booking.inventory.select_category')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Add Inventory Items</h6>
                    @include('booking.inventory.create_item')
                </div>

                <div style="height:420px" class="card-body overflow-auto" id="items_container">
                    @include('booking.inventory.items')
                </div>

            </div>
        </div>
    </div>

    @php $limit_execeed = false; @endphp

    <div id="selected_items" class="row col-12">
        @include('booking.inventory.selected_items')
    </div>

    <div class=" mt-3">
        
        <hr>
        @include('booking.inventory.accuracy')

        <div class="col-md-12 text-center mt-5">
            <a href="/booking/{{ ($booking->booking_id) ?: null }}/4" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
            <a href="#accuracy-box" type="button" class="btn btn-dark m-auto hvr-icon-wobble-horizontal" id="open-accuracy" onclick="open_accuracy()"><i class="fas fa-save hvr-icon"></i> Save</a>
            {{-- <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue  <i class="fas fa-chevron-right hvr-icon"></i></button> --}}

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade " id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="false">
    <div class=" modal-dialog modal-full-height modal-right modal-notify modal-info drop" role="document">
      <div class="modal-content ">
        <!--Header-->
        <div class="modal-header yellow-bg">
          lorium ipsum
  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">×</span>
          </button>
        </div>
  
        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
           
  
 <div class="mb-2">
          <div class="form-check col-12 mb-4 div-color1 m-auto" id="survival_box" onclick="select_kit('survival')">
      <label style="text-align: center; font-size: 18px;" class="form-check-label ml-2 col-12 " for="radio-179">
              Survival Kit ($100):</br>

             
<span style="padding-top: 10px; text-align: center; font-size: 13px;">1 blow up mattress</span></br>
<span style="padding-top: 10px; text-align: center; font-size: 13px;">1 blow up couch</span></br>
<span style="padding-top: 10px; text-align: center; font-size: 13px;">1 toiletries kit</span></br>(${{isset($survival_kit) ? $survival_kit : 0}})</label>
          

           
          </div></div>
    
  
          <div class="form-check mb-4 div-color1 col-12   m-auto  pt-3" id="supplies_box" onclick="select_kit('supplies')">
       <label style="text-align: center" class="form-check-label ml-2 col-12" for="radio-179 "><span style="">Supplies Kit ($100):</span> </br><span style="padding-top: 30px; text-align: center; font-size: 12px;">Based on your inventory size</span></br>
              (${{isset($supplies_kit) ? $supplies_kit : 0}})
            </label>
            
          </div>
  
          </div>
          <!-- Radio -->
  
        
  
        </div>
  
        <!--Footer-->
        <div style="
            border-top: 1px solid #dee2e6; 
        " class="modal-footer justify-content-center">
            <form action="/booking/{{ ($booking->booking_id) ?: null }}/6" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
               <input type="hidden" name="kit" id="kit" />
                <button type="submit" name="btn_kit_check" value="1" class="btn yellow-bg  dvvv drop-btn">Get it now <i class="far fa-gem ml-1 text-white"></i></button>
               
          <!--<a type="button" class="btn yellow-b    g  dvvv drop-btn">Get it now-->
          <!--  <i class="far fa-gem ml-1 text-white"></i>-->
          <!--</a>-->
             <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" type="button" class="btn btn-outline-success dvvv drop-btn">No, thanks</a>
             </form>
          <!--<a type="button" class="btn btn-outline-success dvvv drop-btn" data-dismiss="modal">No, thanks</a>-->
        </div>
                 </div>
                 
    </div>

  <!-- Modal: modalPoll -->




</div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    <!--<div class="modal fade " id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="background: #000000aa">-->
    <!--    <div class=" modal-dialog modal-full-height modal-right modal-notify modal-info drop" role="document">-->
    <!--        <div class="modal-content ">-->
                <!--Header-->
    <!--            <div class="modal-header bg-warning text-light">-->
    <!--                ...-->
    <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--                    <span aria-hidden="true" class="white-text">×</span>-->
    <!--                </button>-->
    <!--            </div>-->

                <!--Body-->
    <!--            <div class="modal-body">-->
    <!--                <div class="text-center">-->
    <!--                    <hr>-->
                        <!-- Radio -->
    <!--                    <p class="text-center"></p>-->
    <!--                    <div class="form-check mb-4 div-color1" id="survival_box" onclick="select_kit('survival')">-->
    <!--                        <label class="form-check-label ml-2" for="radio-179">Survival Kit: 1 blow up mattress, 1 blow up couch, </br>1 toiletries kit (${{isset($survival_kit) ? $survival_kit : 0}})</label>-->
    <!--                    </div>-->
    <!--                    <div class="form-check mb-4 div-color1" id="supplies_box" onclick="select_kit('supplies')">-->
    <!--                        <label class="form-check-label ml-2" for="radio-279">Supplies Kit: Based on your inventory size (${{isset($supplies_kit) ? $supplies_kit : 0}})</label>-->
    <!--                    </div>-->
    <!--                </div>-->
                    <!-- Radio -->
    <!--            </div>-->
                <!--Footer-->
    <!--            <div style="border-top: 1px solid #dee2e6; " class="modal-footer justify-content-center">-->
    <!--                <form action="/booking/{{ ($booking->booking_id) ?: null }}/6" method="post" enctype="multipart/form-data">-->
    <!--                    {{ csrf_field() }}-->
    <!--                    <input type="hidden" name="kit" id="kit" />-->
    <!--                    <button type="submit" name="btn_kit_check" value="1" class="btn bg-warning dvvv drop-btn">Get it now <i class="far fa-gem ml-1 text-white"></i></button>-->
    <!--                    <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" type="button" class="btn btn-outline-success dvvv drop-btn">No, thanks</a>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
@endsection
@section('scripts')
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
{{-- <script src="{{asset('asset/js/inventory_slide.js')}}"></script> --}}
<script src="{{asset('asset/booking/inventory.js')}}"></script>
<script src="{{asset('switchery-master/dist/switchery.min.js')}}"></script>
<script src="{{asset('asset/notiflix/notiflix-2.3.1.min.js')}}"></script>
<script src="{{asset('asset/notiflix/notiflix-aio-2.3.1.min.js')}}"></script>
<script>
    @isset($show_alert)
    Notiflix.Report.Info(
        'Confirmation',
        'New Item is created!',
        'Okay'
    );
    @endisset

    jQuery(document).ready(function() {
        // disable form submitting by enter key
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        // preset ajax functionality
        $('.btn_preset').on('click', function() {
            let preset = $(this).val()
            $('#preset').val(preset)
            let post_data = $('#choose_preset').serializeArray()
            let url = $('#choose_preset').attr('action')
            $.ajax({
                url: url,
                type: 'POST',
                data: post_data,
                success: function(data) {
                    $('#items_container').empty()
                    $('#items_container').append(data)
                }
            })
        })

        $('#item_search').autocomplete({
            source: search_sources,
            select: function(event, ui) {
                update_items_box_search(ui.item.value)
            }
        });

        $('.btn_update').on('click', function() {
        })
    });

    function update_item_info(booking_item_id) {
        console.log(booking_item_id)
        $('#item_info_'+booking_item_id).modal('hide')

        let post_data = $('#update_item_'+booking_item_id).serializeArray()
        let url = $('#update_item_'+booking_item_id).attr('action')
        $.ajax({
            url: url,
            type: 'POST',
            data: post_data,
            success: function(data) {
                $("#selected_items").empty();
                $("#selected_items").append(data);
            }
        })

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/show_selected_items/"+booking_id,
            type: 'POST',
            success: function(data) {
                $('#items_container').empty()
                $('#items_container').append(data)
            }
        })
    }

    function update_items_box_search(search) {
        $('#item_search').val(search)
        let post_data = $('#search').serializeArray()
        let url = $('#search').attr('action')
        $.ajax({
            url: url,
            type: 'POST',
            data: post_data,
            success: function(data) {
                $('#items_container').empty()
                $('#items_container').append(data)
            }
        })
    }

// $(function() {
//   $('.div-color2').click(function() { // when a .myDiv is clicked
//     $('.div-color2').not(this).removeClass('active32')
//     $(this).toggleClass('active32')
//   })
// })


    var booking_id = '{{$booking->booking_id}}'
    var pick_up_loc_id = '{{$booking_location[0]->booking_loc_id}}'
    var drop_off_loc_id = '{{$booking_location[1]->booking_loc_id}}'

    function add_preset(items) {
        if (items.length == 1) {
            $('#item_add_' + items[0].id).modal('show')
        } else if (items.length >= 2) {
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

        let post_data2 = $('#choose_preset').serializeArray()
        let url = $('#choose_preset').attr('action')
        $.ajax({
            url: url,
            type: 'POST',
            data: post_data2,
            success: function(data) {
                $('#items_container').empty()
                $('#items_container').append(data)
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
@endsection
