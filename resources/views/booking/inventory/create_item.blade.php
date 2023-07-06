<div class="row">
    <div class="col-md-8">
        <form action="{{ route('show_searched_item', $booking->booking_id) }}" method="post" enctype="multipart/form-data" class="m-0" id="search">
            {{ csrf_field() }}
            <div class="input-group w-100">
                <input name="item_search" type="text" class="form-control"
                    placeholder="Search..." id="item_search">
                <div class="input-group-append" style="display: none">
                    <button type="submit" name="btn_search" value="true" class="btn btn-dark" id="btn_search">
                        <i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        <button class="btn bg-warning btn-block" onclick="show_modal()"><i class="fas fa-plus mr-2"></i>Create your item</button>

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