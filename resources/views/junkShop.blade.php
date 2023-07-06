@extends('user.layout.app')

@section("styles")
    <link rel="stylesheet" href="{{ asset("asset/css/newDesignStyle.css") }}">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}

        img {
            margin-left: 0 !important;
        }

        .myActive{
            background-color: #FECD2A !important;
            color: #1C2D48 !important;
            border-radius: 15px;
            padding: 3px !important;
        }
        .item-img{
            margin-left: 0;
            margin-top: 0;
            padding: 0 0 10px;
            font-size: 20px;
        }
        .quantity-buttons{
            margin-top: 0;
            text-align: center;
        }
        input, button{
            margin: 0 !important;
        }
        .quantity-buttons *{
            margin: 0 !important;
            padding: 0 7px;
        }
        .footer{
            height: auto !important;
        }
        .text-center{
            margin-top: 0 !important;
        }
        .custom-btn{
            color: #fec83d;
            background-color: #1c2d48;
            border-color: #1c2d48;
            font-weight: 800;
        }
        .modal-content{
            border: 5px solid #0e1724   ;
            border-radius: 8px;
        }
        #cart .img-fluid{
            width: 40px;
            height: 40px;
        }
        .preset-design{
            list-style: none;
            display: inherit;
            font-weight: bold;
            /*margin-top: 15px;*/
        }
        .preset-design li a{
            color: #fecd2a;
            margin-left: 15px;
        }
        .slide-choti{
            height: 200px;
            overflow-y: scroll;
        }
        .slide{
            text-align: center;
            height: 50px;
        }
        .slide img{
            width: 50px;
        }
        .custom-image{
            padding: 10px;
        }
        .btn-sm{
            margin: 0 !important;
            height: 29px;
            background-color: #1c2d48;
            color: white;
            border: 2px solid #aa0114;
            width: 60px;
        }
        .search{
            border: 2px solid red;
            background: #fecd2a;
            font: small-caption;
            color: white;
            padding-bottom: 10px;


        }
        @media only screen and (max-width: 1040px) {
            .slide-choti{
                height: 150px;
                padding: 10px;
            }
            .owl-item{
                margin-right: 30px;
                width: 40px!important;
            }
            .preset-design{
                margin-top: -5px;
            }
        }
        @media screen and (min-width: 1000px) and (max-width: 1480px) {
            .preset-design{
                margin-top: 15px;
            }
        }
        .search_keys{
            margin: 0;
        }
        .nav-margin{
            margin-top: 50px !important;
        }
    </style>
@endsection

@section('content')
    <form action="javascript:;" method="post">
        {{ csrf_field() }}

        <div class="content container d-block mx-auto" style="display: inline-block;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="heading">
                        <h1>
                            What will we be Hauling?
                        </h1>
                    </div>
                </div>
            </div>
            @if($presets)
                <nav class="navbar navbar-expand-lg navbar-light bg- #1C2D48">
                    <ul class="preset-design">
                        @foreach($presets as $index => $preset)
                            <li>
                                <a onclick="getPreset(this, null, {{ $preset->id }})" href="javascript:;">
                                    {{ $preset->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif
            <div class="container">
                <div class="customer-logos slide-choti">
                    <div class="row">
                        <input type="text" name="search" onkeyup="filterList(this)" id="search" class="form-control text-center search" placeholder="Search Here">
                    </div>
                    <div class="row">
                        @foreach($items as $item)
                            <a href="javascript:;" data-name="{{ $item->name }}" onclick="addToList('{{ $item->name }}', '{{ $item->id }}', '{{ $item->image }}')">
                                <section class="col-lg-1 custom-image">
                                    <div class="slide">
                                        <img src="{{ $item->image }}" class="img-fluid">
                                    </div>
                                    <p class="text-center search_keys" style="height:50px;">{{ $item->name }}</p>

                                    <button  class="btn-sm" type="button">Add</button>
                            </a>
                                </section>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="row emptyslider1" style="margin: 30px 0px; height: auto;padding: 10px;" id="cart">
                        @foreach(Cart::content() as $item)
                            <div class="col-md-2">
                                <img src="{{ \App\Inventory::find($item->id)->image }}" class="img-fluid my-3 d-block mx-auto">
                                <h2 class="item-img">{{ $item->name }}</h2>
                                <div class="quantity-buttons">
                                    <button type="button" id="sub_{{ $item->id }}" onclick="removeToCart(this,{{ $item->id }})" class="sub" style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">-</button>
                                    <input type="text" id="" readonly value="{{ $item->qty }}" class="col-3">
                                    <button type="button" id="add_{{ $item->id }}" onclick="addToCart(this,{{ $item->id }})" class="add" style="background-color: #aa0114;border: none;color: white;border-radius: 2px;">+</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="row container-fluid">
                <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                    <button type="submit" onclick="window.location.href = '/cart'" class="my-2 btn-footer pull-right">Continue</button>
                </div>
            </div>
        </div>
        <br>
    </form>
    <div id="questionModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="border: none;padding: 0">
                    <h2 style="padding: 0">&nbsp;</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center" id="questionBody">
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="{{ asset('asset/js/junkShop.js') }}"></script>

@endsection

