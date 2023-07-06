@extends('user.layout.app')

@section('styles')
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        .radio {
            position: relative;
            cursor: pointer;
            line-height: 20px;
            font-size: 14px;
        }

        .radio .label {
            position: relative;
            display: block;
            float: left;
            margin-right: 10px;
            width: 20px;
            height: 20px;
            border: 2px solid #c8ccd4;
            border-radius: 100%;
            -webkit-tap-highlight-color: transparent;
        }

        .radio .label:after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 10px;
            height: 10px;
            border-radius: 100%;
            background: #225cff;
            transform: scale(0);
            transition: all 0.2s ease;
            opacity: 0.08;
            pointer-events: none;
        }

        .radio:hover .label:after {
            transform: scale(3.6);
        }

        input[type="radio"]:checked + .label {
            border-color: #225cff;
        }

        input[type="radio"]:checked + .label:after {
            transform: scale(1);
            transition: all 0.2s cubic-bezier(0.35, 0.9, 0.4, 0.9);
            opacity: 1;
        }

        .cntr {
            position: absolute;
            top: calc(50% - 35px);
            left: 0;
            width: 100%;
            text-align: center;
        }

        .hidden {
            display: none;
        }

        .credit {
            position: fixed;
            right: 20px;
            bottom: 20px;
            transition: all 0.2s ease;
            -webkit-user-select: none;
            user-select: none;
            opacity: 0.6;
        }

        .credit img {
            width: 72px;
        }

        .credit:hover {
            transform: scale(0.95);
        }

        .parking-info .radio .label {
            display: block;
        }

    </style>
@endsection

@section('content')

    <style>
        .redio {
            text-align: center;
            font-size: 50px;


        }

        .text {
            text-align: center;
            line-height: 20px;
            color: #20374f;
        }

        .with {
            width: 130px;
        }

        h3 {

            width: 100%;
            text-align: left;
            border-bottom: 6px solid #000;
            line-height: 1em;
            margin: 10px 0 20px;
        }

        h3 span {

            padding: 0 10px;
        }

        h2 {
            font-size: 100px;
            color: #20374f;
        }

        body {
            background-color: #ffc81c !important;
            font-family: lulo-clean-w01-one-bold, sans-serif !important;
        }


        .active {
            font-size: 34px !important;
            border: 3px solid black;
            border-radius: 25px;
            height: 45px;
            color: red;
            padding-top: 3px;
            display: block !important;
            width: 46px;
            margin: 16px auto;
        }

        @media only screen and (max-width: 600px) {
            .with {
                width: 100%;
            }
        }

        .myBorder {
            border: 1px solid black;
            padding: 3px;
            background: black;
            margin: 10px;
        }
    </style>

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
                <section class="border section col-md-10 offset-md-1" style="min-height: 500px;">

                    <div class="form-row  form-group">
                        <div class="col-12 text-center pickup-details">
                            <h2 style="font-size: 50px; color:#ffffff">Your Items</h2>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-2"></div>
                        <div class="col-4">
                            <div class="row">
                                <ul>
                                    @foreach(Cart::content() as $cart)
                                        <li><h5>{{ $cart->name }}</h5></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <ul>
                                    @foreach(Cart::content() as $cart)
                                        <li><h5>{{ $cart->qty }}</h5></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--LOCATION DETAILS BOX ENDS-->
        <!--SAVE AND BACK BUTTONS-->
        <div class="footer" style="position: fixed; bottom: 0; width: 100%;">
            <div class="container-fluid">
                <div class="row">
                    </br>
                    <section class="col-md-8 offset-md-4 text-right">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cont-btn">
                            @if($location == "login")
                                <a href="javascript:;" onclick="window.location = '{{ url("login") }}'" class="btn btn-danger back">Place Order</a>
                            @else
                                <a href="javascript:;" onclick="$('#formLocation').submit()" class="btn btn-danger back">Place Order</a>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
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
			if (val === 'show'){
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
			$('.redio').on('click', function (event) {
				$('.active').removeClass('active fa-circle').addClass('fa-circle-thin');
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
