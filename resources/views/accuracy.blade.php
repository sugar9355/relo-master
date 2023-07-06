@extends("user.layout.app")

@section("styles")
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
            background-color:#ffc81c !important;
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
    </style>
@endsection

@section("content")
    <form action="/accuracy" method="post" id="dateForm">
        {{ csrf_field() }}
        <div class="container-fluid">
            <div class="row">
                <div class="top-bar col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="/asset/img/lapture.png" />
                </div>
            </div>
        </div>
        <input type="hidden" name="accuracy" id="accuracy" value="Not Accurate">
        <div class="container">
            <!-- Row 1 -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h2 style="font-size: 30px"><b>Please select inventory accuracy:</b>
                        <i class="fa fa-info-circle" aria-hidden="true" style="margin-left: 20px; "></i>
                    </h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p style="font-size: 15px; color: #20374f;
">Please be as helpful as possible in this category.
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
                        <i class="fa fa-circle active "></i>
                    </div>
                    <h5 class="text">Not Accurate</h5>
                    <p class="text">Have Not packed or not sure</p>
                </div>

                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                        <i class="fa fa-circle-thin "></i>
                    </div>
                    <h5 class="text">Somewhat Accurate</h5>
                    <p class="text">most of the big stuff</p>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                        <i class="fa fa-circle-thin "></i>
                    </div>
                    <h5 class="text">Accurate</h5>
                    <p class="text">Puls or minus a faw items</p>
                </div>

                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <h3 class="with"><span></span></h3>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="redio">
                        <i class="fa fa-circle-thin "></i>
                    </div>
                    <h5 class="text">Very Accurate</h5>
                    <p class="text">inventory 100% accurate</p>
                </div>
                <!-- Labels and Inputs of Row 2 -->
            </div>
        </div>
        <div class="footer">
            <div class="row container-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">

                    <button type="submit" class="my-2 btn-footer pull-right" style="background-color: #aa0114 !important;width: 130px;height: 40px;border: none !important;color: white;">
                        Continue
                    </button>

                </div>
            </div>
        </div>
    </form>

@endsection

@section("scripts")
    <script>
        $(function(){
            $('.redio').on('click', function(event){
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
