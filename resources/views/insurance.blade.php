@extends('user.layout.app')

@section('styles')
    <!--style>
        section.pricing {
            background: #ffc81c;
            /*background: linear-gradient(to right, #0062E6, #33AEFF);*/
        }

        .pricing .card {
            border: none;
            border-radius: 1rem;
            transition: all 0.2s;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .pricing hr {
            margin: 1.5rem 0;
        }

        .pricing .card-title {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            letter-spacing: .1rem;
            font-weight: bold;
        }

        .pricing .card-price {
            font-size: 3rem;
            margin: 0;
        }

        .pricing .card-price .period {
            font-size: 0.8rem;
        }

        .pricing ul li {
            margin-bottom: 1rem;
        }

        .pricing .text-muted {
            opacity: 0.7;
        }

        .pricing .btn {
            font-size: 80%;
            border-radius: 5rem;
            letter-spacing: .1rem;
            font-weight: bold;
            padding: 1rem;
            opacity: 0.7;
            transition: all 0.2s;
        }

        button {
            background-color: #aa0114 !important;
            border: solid 2px white;
            color: white;
            padding: 5px;
            padding-left: 25px;
            padding-right: 25px;
        }

        /* Hover Effects on Card */

        @media (min-width: 992px) {
            .pricing .card:hover {
                margin-top: -.25rem;
                margin-bottom: .25rem;
                box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
            }

            .pricing .card:hover .btn {
                opacity: 1;
            }
        }
    </style-->
@endsection

@section('content')


 <div class="container my-5"> 
    <h1 class="text-center text-uppercase">Select Insurance Type</h1>
        <hr>

    <form action="{{ url('insurance') }}" method="post">
        {{ csrf_field() }}

                <div class="row my-4">
                    <div class="col-md-12">

                       <div class="card card-body">
                        <select name="insurance_type" id="insurance_type" class="form-control">
                            @foreach ($insuranceCategories as $insuranceCategory)
                                <option value="{{ $insuranceCategory->id }}">{{ $insuranceCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </div>
                <div class="row">
                    @foreach ($insuranceCategories as $insuranceCategory)
                        <div class="col-lg-4">
                                <div class="card mb-5 mb-lg-0 card-body bg-dark hvr-shadow w-100">
                                    <h5 class="card-title text-uppercase text-center text-white m-0">{{ $insuranceCategory->name }}</h5>
                                    <hr>
                                    <ul class="fa-ul" style="margin-left: 0px;">
                                        @foreach (Cart::content() as $item)
                                            <div class="row">
                                                <li class="col-lg-2" style="">
                                                    <label>Item</label>
                                                    <div class="py-2">
                                                        <span>{{ $item->name }}</span>
                                                    </div>
                                                </li>
                                                <li class="col-lg-2" style="">
                                                    <label>Image</label>
                                                    <div class="py-2">
                                                        <img src="{{ \App\Inventory::find($item->id)->image }}" alt="Item Image">
                                                    </div>
                                                </li>
                                                <li class="col-lg-2" style="">
                                                    <label>Qty</label>
                                                    <div class="py-2">
                                                        <span id="qty_{{ $item->id }}_{{ $insuranceCategory->id }}">
                                                            ({{ $item->qty }}) x
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="col-lg-3">
                                                    <label>You Pay</label>
                                                    <input class="input-sm form-control" value="0"
                                                           name="{{ $insuranceCategory->id }}_{{ $item->id }}[]"
                                                           onkeyup="changeVal(this,'{{ $item->id }}', '{{ $insuranceCategory->id }}')">
                                                </li>
                                                <li class="col-lg-3">
                                                    <label>We Pay</label>
                                                    <input class="input-sm form-control" value="0"
                                                           name="{{ $insuranceCategory->id }}_{{ $item->id }}[]"
                                                           id="pay_{{ $item->id }}_{{ $insuranceCategory->id }}"
                                                           readonly>
                                                </li>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                    @endforeach
                </div>
				
				 <div class="col-md-12 text-right">
            
                						  <hr>   
                
                
                    <button type="submit" class="btn btn-dark m-auto ">Continue</button>
                
            
        </div>
            </div>

        </section>
       
    </form>
</div>




    <!-- Modal -->
    <div class="modal fade" id="itemsListModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
		function changeVal(me, id, insuranceId) {
			let val = parseInt($(me).val());
			let qty = $(`#qty_${id}_${insuranceId}`).html();
			qty = qty.match(/\d/g).join("");

			if (isNaN(val)) {
				$(`#pay_${id}_${insuranceId}`).val(0);
				return;
			}

			$.get("/get_ratio/" + insuranceId, (data) => {
				let ratio = data.ratio.split(':')[1];
				let calculatedValue = val * parseInt(ratio);
				calculatedValue = parseInt(qty) * calculatedValue;
				$(`#pay_${id}_${insuranceId}`).val(calculatedValue);
			});
		}
    </script>
@endsection