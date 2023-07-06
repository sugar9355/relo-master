@extends('user.layout.app')

@section('styles')
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
<style>
@import url(http://fonts.googleapis.com/css?family=Montserrat:400,700);
.modal-wrapper {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0; 
    left: 0;
    background: rgba(0, 0, 0, 0.4);
    visibility: hidden;
    opacity: 0;
    -webkit-transition: all 0.25s ease-in-out;
    transition: all 0.25s ease-in-out;
}

.modal-wrapper.open {
    opacity: 1;
    z-index: 10;
    visibility: visible;
}

.modal {
    width: 450px;
    height: 300px;
    display: block;
    margin: 50% 0 0 -202px;
    position: relative;
    top: 50%; 
    left: 50%;
    background: #fff;
    opacity: 0;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
}

.modal-wrapper.open .modal {
    margin-top: -200px;
    opacity: 1;
}

.head { 
    padding: 12px 30px;
    overflow: hidden;
    background: #8BC03A;
}

.btn-close {
    font-size: 28px;
    display: block;
    float: right;
    color: #fff;
}

.good-job {
    text-align: center;
    font-family: 'Montserrat', Arial,       Helvetica, sans-serif;
    color: #8BC03A;
}
.good-job .fa-thumbs-o-up {
    font-size: 60px;
}
.good-job h1 {
    font-size: 45px;
}



</style>
@endsection

@section('content')

    <div class="container my-5">
    
       <h4 class="text-center animated fadeIn delay-0-2s"><i class="fas fa-people-carry animated bounceIn delay-0-2s"></i> SERVICE TYPE</h4>
        <hr>
        <div class="row">
            @foreach($services as $service)
                <div class="col-xl-6 col-md-6 col-xs-12 col-sm-12 mt-3">
                    <div class="card card-body rounded text-center hvr-shadow d-block animated bounceIn delay-0-2s">                        
                        
                            <h3 class="m-0" data-val="{{ $service->type }}">{{ $service->name }}</h3>
                            <hr>
                            <p>{{ $service->description }}</p>
                            
                            @if(isset($booking->booking_id))
                                <form action="/booking/{{ $booking->booking_id }}" method="post" enctype="multipart/form-data">
                            @else
                                <form action="/booking" method="post" enctype="multipart/form-data">
                            @endif
                            
                                {{ csrf_field() }}
                                
                                <input name="service_type_id" type="hidden" value="{{ $service->id }}">
                                <button name="btn_submit" type="submit" value="1" class="btn btn-warning hvr-wobble-vertical w-50 m-auto @if(isset($booking->service_type_id) && ($booking->service_type_id == $service->id)) active @endif">Select</button>
                                
                            </form>
                    </div>
                </div>
            @endforeach
           
        </div>
    
            
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Mode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="opt1" class="radio">
                                <input type="radio" name="mode" id="opt1" hidden class="hidden"/>
                                <span class="label"></span> I am picking up
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label for="opt2" class="radio">
                                <input type="radio" name="mode" id="opt2" hidden class="hidden"/>
                                <span class="label"></span> I need to be picked up
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="handleRedirect()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="modal-wrapper">
    <div class="modal">
        <div class="head">
            <a class="btn-close trigger" href="#">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
        <div class="content" style="padding: 10%">
            <div class="good-job">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                <h3 style="display: block;
                font-size: 1.17em;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;">Your Booking has been Confirmed</h3>
                <h3 style="display: block;
                font-size: 1.17em;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;">Check Your emails for details</h3>
            </div>
        </div>
    </div>
</div>
  

@endsection
@section('scripts')
<script>
    @isset($end_booking)
    $(document).ready(function() {
        $('.modal-wrapper').toggleClass('open');
        $('.page-wrapper').toggleClass('blur-it');

        $('.btn-close').click(function() {
            $('.modal-wrapper').toggleClass('open');
            $('.page-wrapper').toggleClass('blur-it');
        })
    });
    @endisset
</script>
@endsection
