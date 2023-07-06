<style>
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
</style>
<div class="row">
    <div class="col-md-10">
        <form action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post"
            enctype="multipart/form-data" class="m-0" id="search">
            {{ csrf_field() }}
            <div class="input-group w-100">
                <input name="item_search" type="text" class="form-control" value="@if(isset($search)){{$search}}@endif"
                    placeholder="Search..." id="item_search">
                <div class="input-group-append">
                    <button type="submit" name="btn_search" value="true" class="btn btn-dark" id="btn_search"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        <button class="btn bg-warning btn-block" onclick="show_modal()"><i class="fas fa-plus"></i> Create</button>

        <div id="create_item" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="m-0">Create New Item</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">

                        <form action="/booking/{{ ($booking->booking_id) ?: null }}" method="POST"
                            enctype="multipart/form-data">
                            {{csrf_field()}}

                            <input name="create_item" type="hidden" class="btn btn-success" value="true">
                            <div class="form-row">
                                <div class="col-8 "> <label class="col-12 nopad pure-material-textfield-filled">
                                        <input placeholder=" " name="name" value="" required>
                                        <span>Inventroy Item Name</span>
                                    </label></div>

                                <div class="col-4">
                                    <label class="col-12 nopad pure-material-textfield-filled">
                                        <input type="number" placeholder=" " name="quantity" value="" required>
                                        <span>Inventory Quantity</span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6 mb-0">
                                    <strong>Inventroy Item Name:</strong> <input class="form-control" min=0 type="text"
                                        name="name" value="" required>
                                </div> --}}

                                {{-- <div class="form-group col-md-4 mb-0">
                                   <strong>Inventroy Quantity:</strong> <input class="form-control" min=0 type="number"
                                        name="quantity" value="" required>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt-3">
                                        <label><strong>How Heavy is Your Item</strong>

                                            <i style="float:right; " class="far fa-edit mt-1 ml-4"></i>
                                        </label>

                                        <div class="row">
                                            <div class="col-md-12 d-flex">
                                                <nav class="col-12 mt-3 mb-3">
                                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                        @foreach($items_weight as $weight)

                                                        <a class="boxes-bulk1 nav-item nav-link col-2 weight_clickable text-center border-right"
                                                            id="nav-home-tab" data-toggle="tab" role="tab"
                                                            data-index="0" data-value="{{$weight->id}}"
                                                            aria-controls="nav-home" aria-selected="false">
                                                            <div class="nav-tab-set">{{$weight->name}}
                                                            </div>
                                                        </a>
                                                        @endforeach
                                                        <input type="hidden" name="itemWighttype" class="itemWighttype">
                                                    </div>
                                                </nav>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-0  weight-Class">

                                                        <div class="col-4">
                                                            <div class="col-md-12">
                                                                <a class="text-info" style="cursor: pointer"
                                                                    onclick="show_weight_box()"><small>know the Weight
                                                                        of your item?</small></a>
                                                            </div>

                                                            <label
                                                                class="weight_box nopad pure-material-textfield-filled mt-3"
                                                                style="display: none">
                                                                <input type="number" placeholder=" "
                                                                    name="dimensionname" value="" required>
                                                                <span>Item Weight</span>
                                                            </label>
                                                        </div>
                                                        {{-- 
                                    <strong>Item Weight:</strong> <input class="form-control" min=0 type="number"
                                        name="dimensionname" value="" required> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-12">
                                        <label><strong>How Big is Your Item</strong>
                                            <i style="float:right; " class="far fa-edit mt-1 ml-4"></i>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    @foreach($item_dimension as $dimension)
                                                    <a style="padding:0px;"
                                                        class="boxes-bulk1 nav-item nav-link col-2 dimensions_clickable text-center align-middle"
                                                        id="nav-home-tab" data-toggle="tab" role="tab" data-index="0"
                                                        data-value="{{$dimension->id}}" aria-controls="nav-home"
                                                        aria-selected="false">
                                                        <div class="nav-tab-set  col-11 nopad cen">{{$dimension->name}}
                                                        </div>
                                                    </a>
                                                    @endforeach
                                                    <input type="hidden" name="itemdimensiontype"
                                                        class="itemdimensiontype">
                                                </div>
                                            </nav>
                                        </div>
                                        <div class="col-md-12 mt-3 item_dimensionss">
                                            <div class="col-md-12">
                                                <a class="text-info" style="cursor: pointer"
                                                    onclick="show_dimension_box()"><small>know the dimensions of your
                                                        item?</small></a>
                                            </div>
                                <div class="col-md-12 mt-3 item_dimensionss">
                                <div class="form-row">
                                <div class="form-group col-md-4 mb-0">
                                    {{-- <strong>Item Width:</strong> <input class="form-control" min=0 type="number"
                                        name="itemwidth" value="" required> --}}
                                        
                                            <label class="col-12 nopad pure-material-textfield-filled">
                                                <input type="number" placeholder=" " name="itemwidth" value="" required>
                                                <span>Item Min Volume</span>
                                              </label>
                                       
                                </div>
                                <div class="form-group col-md-4 mb-0">
                                    {{-- <strong>Item height:</strong> <input class="form-control" min=0 type="number"
                                        name="itemheight" value="" required> --}}
                                              
                                        <label class="col-12 nopad pure-material-textfield-filled">
                                            <input type="number" placeholder=" " name="itemheight" value="" required>
                                            <span>Item Max Volume</span>
                                          </label>
                                </div>
                                <div class="form-group col-md-4 mb-0">
                                    {{-- <strong>Item breadth:</strong> <input class="form-control" min=0 type="number"
                                        name="itembreadth" value="" required>
                                </div> --}}
                                      
                               <!--  <label class="col-12 nopad pure-material-textfield-filled">
                                    <input type="number" placeholder=" "  name="itembreadth" value="" required>
                                    <span>Item Breadth</span>
                                  </label> -->
                            </div>
                            </div>
                            <div class="input-group mb-3 mt-3 col-6">
                             
                                <div class="custom-file">
                                    <input type="file" />
                                    <img src="../../asset/img/gg.png" alt="" class="rounded float-left img-thumbnai col-3">
                                </div>
                              </div>
                              {{-- <img src="/uploads/inventory/11_Medium Box.png" class="rounded float-left img-thumbnai col-3" alt="..."> --}}
                        </div>
                    {{-- <img src="/uploads/inventory/11_Medium Box.png" class="rounded float-left img-thumbnai col-3" alt="..."> --}}

                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="modal-footer">
                                    <button name="btn_submit" type="submit" class="btn btn-success" value="5">Add
                                        Item</button>
                                    <button type="button" class="btn btn-default border border-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $('.v_factor').keyup(function() {
        $('#volume').val($('#breadth').val() * $('#height').val() * $('#width').val());
    })
    $('.v_factor').change(function() {
        $('#volume').val($('#breadth').val() * $('#height').val() * $('#width').val());
    })
    @php
        echo 'var search_sources = ' . json_encode($items_array) . ';';
    @endphp
    $('#item_search').autocomplete({
        source: search_sources,
        select: function(event, ui) {
            $('#item_search').val(ui.item.value)
            $('#btn_search').trigger('click')
        }
    });

   $('.dimensions_clickable').click(function(){
    $('.itemdimensiontype').val($(this).data('value'));
    $('.item_dimensionss').css('display','none');
    
    $('.item_dimensionss input').removeAttr('required');
   })
   $('.fa-edit').click(function(){
    $('.itemdimensiontype').val($(this).data('value'));
    $('.item_dimensionss').css('display','block');
    

   })
  
   

$('.weight_clickable').click(function(){
    $('.itemWighttype').val($(this).data('value'));
     $('.weight-Class').css('display','none');
    $('.weight-Class input').removeAttr('required');
   })

    
   $('.fa-edit').click(function(){
    $('.itemWighttype').val($(this).data('value'));
     $('.weight-Class').css('display','block');
   
   })

   var imgBtn = document.querySelector('img');
var fileInp = document.querySelector('[type="file"]');

imgBtn.addEventListener('click', function() {
  fileInp.click();
})

function show_modal() {
    $('.weight_box').hide()
    $('.dimension_box').hide()
    $('#create_item').modal('show')
}

function show_weight_box() {
    $('.weight_box').fadeIn()
}

function show_dimension_box() {
    $('.dimension_box').fadeIn()
}
</script>