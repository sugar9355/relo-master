@extends('user.layout.app')

@section('styles')
 
@endsection

@section('content')

    <!--SEARCH BAR STARTS-->
    <form action="/checkout" id="formLocation" method="post">
        {{ csrf_field() }}
        <div>
            <div class="heading">
                <h1>You Order</h1>
            </div>
        </div>
        <!--ADD LOCATION ENDS-->

        <div class="container">
            <div class="row">
                <section class="border section col-md-10 offset-md-1">

                    <div class="form-row  form-group">
                        <div class="col-12 text-center pickup-details">
                            <h2 style="font-size: 50px; color:#ffffff">Your Items</h2>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <div class="row">
                                <ul>
                                    @foreach(Cart::content() as $cart)
                                        <li><h5>{{ $cart->name }}</h5></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-12 text-center mb-4">
                            Select item of Packaging
                        </div>
                        <br>
                        <div class="col-3">&nbsp;</div>
                        <div class="col-6">
                            <div class="form-check-inline p-2">
                                <label class="form-check-label radio">
                                    <input type="radio" class="form-check-input" value="hide" hidden onclick="showHideDropDown(this)" name="package">
                                    <span class="label"></span> Do you require Full Service?
                                </label>
                            </div>
                            <div class="form-check-inline p-2">
                                <label class="form-check-label radio">
                                    <input type="radio" class="form-check-input" value="show" hidden onclick="showHideDropDown(this)" name="package">
                                    <span class="label"></span> Select Item required for packaging
                                </label>
                            </div>
                            <select class="select2 form-control" id="dropdown-select2" multiple onchange="addToDescription(this, '#packaging')">
                                @foreach( $items as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <textarea class="col-12" rows="3" style="display: none" id="packaging" name="packaging"
                                          placeholder="Do You Want Packaging?">{{ null }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-12 text-center mb-4">
                            Select item of Junk Removal
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <div class="col-1"></div>
                        <div class="col-4">
                            <div class="row">
                                <ul id="nameList">
                                    @if($junkItems)
                                        @foreach($junkItems as $cart)
                                            <li><h5>{{ \App\Inventory::find($cart['id'])->name }}</h5></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <ul class="list-unstyled" id="qtyList">
                                    @if($junkItems)
                                        @foreach($junkItems as $index => $cart)
                                            <li><h5><span class="myBorder" onclick="minusQty('{{ $index }}')"><i class="fa fa-minus"></i></span><span
                                                            id="qty{{ $index }}">{{ $cart['qty'] }}</span><span class="myBorder"
                                                                                                                onclick="addQty('{{ $index }}')"><i
                                                                class="fa fa-plus"></i></span></h5></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-3">&nbsp;</div>
                        <div class="col-6">
                            <select class="select2 form-control" multiple onchange="addToList(this)">
                                @foreach( $items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--LOCATION DETAILS BOX ENDS-->
        <!--SAVE AND BACK BUTTONS-->

        <div class="container">
            </br>
            </br>
            </br>
            <input type="hidden" name="accuracy" id="accuracy" value="Not Accurate">

            <!-- Row 1 -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2 style="font-size: 20px"><b>Please select inventory accuracy:</b></h2>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Please be as helpful as possible in this category.
                        We understand that estimating is hard so image
                        estimating your job from your estimate.<b>NOT EASY!</b></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
					
                        <label><input type="radio" name="accuracy" value="Not Accurate"> <strong>Not Accurate</strong></label>
                    </div> 
                    
                    <p class="text">Have Not packed or not sure</p>
                </div>

                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                        <label><input type="radio" name="accuracy" value="Somewhat Accurate"> <strong>Somewhat Accurate</strong></label>
                    </div>
                    
                    <p class="text">most of the big stuff</p>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                        <label><input type="radio" name="accuracy" value="Accurate"> <strong>Accurate</strong></label>
                    </div>
                    
                    <p class="text">Plus or minus a few items</p>
                </div>

                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                       <label><input type="radio" name="accuracy" value="Very Accurate"> <strong>Very Accurate</strong></label>
                    </div>
                    
                    <p class="text">inventory 100% accurate</p>
                </div>
                <!-- Labels and Inputs of Row 2 -->
            </div>
			
			 <div class="row">
                    </br>
                    <section class="col-md-8 offset-md-4 text-right">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cont-btn">
                            @if($location == "login")
								
								<a href="/login" class="btn btn-dark m-auto">Login First</a>
                            
                            @else
								<button type="submit" class="btn btn-dark m-auto">Place Order</button>
                            @endif
                        </div>
                    </section>
                </div>
			
        </div>
        <div class="footer">
            
        </div>
    </form>

@endsection

@section('scripts')
    <script>
		$(function () {
			$(".select2").select2();
			$("#dropdown-select2").next('.select2-container').hide();
		});

		function showHideDropDown(me) {
			let val = $(me).val();
			let $mainDropDown = $("#dropdown-select2");
			let $dropdown = $mainDropDown.next('.select2-container');
			$dropdown.hide();
			let $resDiv = $("#packaging");
			$resDiv.val('All');
			if (val === 'show') {
				let dropDownVal = $mainDropDown.val();
				let joinedVal = dropDownVal.join(',');
				$resDiv.val(joinedVal);
				$dropdown.show();
			}

		}

		function addToDescription(me, resDiv) {
			let val = $(me).val().join(',');
			$(resDiv).val(val);
		}

		function addToList(me) {
			let selector = $(me);
			let val = selector.val();
			if (val.length > 0) {
				let id = val[0];
				axios.get(`add_to_junk/${id}`)
					.then(data => {
						let htmlName = `<li><h5>${data.data.name}</h5></li>`;
						$("#nameList").append(htmlName);
						let htmlQty = `<li><h5><span class="myBorder" onclick="minusQty('${data.data.index}')"><i class="fa fa-minus"></i></span><span id="qty${data.data.index}">0</span><span class="myBorder" onclick="addQty('${data.data.index}')"><i class="fa fa-plus"></i></span></h5></li>`;
						$("#qtyList").append(htmlQty);
					})
					.catch(error => {
						console.log(error);
					});
				selector.val("");
				selector.trigger('change');
			}
		}
    </script>
    <script>

		function addQty(index) {
			let selector = $("#qty" + index);
			let val = parseInt(selector.html());
			let newVal = val + 1;
			axios.get(`update_junk/${index}/${newVal}`)
				.then(() => {
					selector.html(newVal);
				})
				.catch(error => {
					console.log(error);
				});
		}

		function minusQty(index) {
			let selector = $("#qty" + index);
			let val = parseInt(selector.html());
			if (val === 0) {
				return;
			}
			let newVal = val - 1;
			axios.get(`update_junk/${index}/${newVal}`)
				.then(() => {
					selector.html(newVal);
				})
				.catch(error => {
					console.log(error);
				});
		}
    </script>
    <script>
		$(function () {
			$('.redio').on('click', function (event) 
			{
				$('.active').removeClass('active fa-circle').addClass('noactive fa-circle-thin');
				let parentSelector = $(event.currentTarget);
				let selector = parentSelector.find('i');
				selector.removeClass('fa-circle-thin');
				selector.addClass('fa-circle active');
				let val = parentSelector.parent().find('h5').text();
				$("#accuracy").val(val);
			})
		});
    </script>
@endsection
