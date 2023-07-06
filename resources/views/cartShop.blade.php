@extends('user.layout.app')

@section('content')


    @if($postLocation != null)
        <form action="{{ "/".$postLocation }}" id="checkOutForm" method="post">
        {{ csrf_field() }}
        @endif
        <!--STARTS HEADING-->

            <div>
                <div class="heading">
                    <h1>What kind of location do you require<br> assistance with?</h1>
                </div>
            </div>

            <!--END HEADING-->
            <!--STARTS SLIDER-->

            <div class="container custom">
                <div class="row">
                    <div class="my-owl-two owl-carousel owl-theme">

                        @if($presets)
                            @foreach($presets as $index => $preset)
                                <div class="item box" onclick="getPreset(this, null, {{ $preset->id }})">
                                    <div class="ca-item">
                                        <div class="ca-item-main">
                                            <img src="{{ $preset->image }}" alt="Avatar" style="width: 100px;border-radius: 50%;margin-top: 30px; ">
                                            <h3> {{ $preset->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="item box" onclick="getPreset(this, 'create')">
                            <div class="ca-item">
                                <div class="ca-item-main">
                                    <img src="{{ asset('asset/img/img_avatar.png') }}" alt="Avatar" style="width: 100px;border-radius: 50%;margin-top: 30px; ">
                                    <h3> Create Your Own</h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="createOwn">
                <div id="presetShow">
                    <!--STARTS HEADING 2-->
                    <div>
                        <div class="booking">
                            <h1 id="preSetHeading">Current Selection</h1>
                        </div>
                    </div>
                    <!--END HEADING 2-->
                    <!--  STARTS BOOKING TABS -->
                    <div class="container book-tab">
                        <div class="row" id="cart">
                            @foreach(Cart::content() as $item)
                                <div class="input-group col-md-4 offset-md-4 bedroom-field">
                                    <img src="{{ \App\Inventory::find($item->id)->image }}" alt="Avatar" style="margin-top: 8px;" width="40" height="40">
                                    <h2 class="item-img">{{ $item->name }}</h2>
                                    <div class="quantity-buttons">
                                        <button type="button" id="sub_{{ $item->id }}" onclick="removeToCart(this,{{ $item->id }})" class="sub">-</button>
                                        <input type="text" id="" readonly value="{{ $item->qty }}" class="field col-1">
                                        <button type="button" id="add_{{ $item->id }}" onclick="addToCart(this,{{ $item->id }})" class="add">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="container book-tab">
                        <div class="row">
                            <div class="input-group col-md-4 offset-md-4 total">
                                <h4 class="col-md-6">Total</h4>
                                <h4 class="col-md-6 total-4 cartTotal">{{ \Cart::count() }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="container" id="addAdditional" onclick="showHideAddMore()">
                        <div class="row">
                            <div class="input-group col-md-3 offset-md-5">
                                <button type="button" class="btn btn-danger add-button">Add Additional Item</button>
                            </div>
                        </div>
                    </div>


                    <!--END BOOKING TABS-->
                </div>
                <div id="addMore">
                    <!--HEADING-->
                    <div>
                        <div class="heading">
                            <h1>Add Items</h1>
                        </div>
                    </div>
                    <!--END HEADING-->

                    <div class="container book-tab">
                        <div class="row">
                            <div class="input-group border-none col-md-6 offset-md-3 total">
                                <select onchange="addToList(this)" class="form-control" id="selectItem">
                                    <option value="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--    -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 offset-2 heading">
                                <h1>Add each item you need moved one at a time</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-end">
                    <a href="/" class="col-md-1 btn btn-danger back">Back</a>
                    @if($postLocation != null)
                        <a href="/cart" id="submitButtons" class="col-md-2 btn btn-danger back" style="">Save And Continue</a>
                    @else
                        <a href="/register" id="submitButtons" class="col-md-2 btn btn-danger back" style="">Save And Continue</a>
                    @endif
                </div>
            </div>
            @if($postLocation != null)
        </form>
    @endif

    <div id="questionModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="questionBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script>
        $(document).ready(function () {
            hideAll();
        });
        @if (\Cart::count() > 0)
        $(document).ready(function(){
            $("#presetShow").show();
            $("#addAdditional").show();
            $("#submitButtons").show();
        });
        @endif
    </script>
    <script src="{{ asset('asset/js/cartShop.js') }}"></script>

@endsection

