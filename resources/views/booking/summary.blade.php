@extends('user.layout.app')

@section('styles')
{{-- notiflix plugin for the popup --}}
<link rel="stylesheet" href="{{asset('asset/notiflix/notiflix-2.3.1.min.css')}}">
<link rel="stylesheet" href="{{asset('asset/css/style-preview.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<link rel="stylesheet" href="{{asset('switchery-master/dist/switchery.min.css')}}">
<style>
    .cursor {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
@include('booking.summary.location')
<div class="top mt-5">
    <div class="time-set">
        <div class="check-flex">
            @php
                if ($booking->flexible == 1) {
                    $img_path = 'asset/img/preview-imgs/icon-tick1.png';
                } else {
                    $img_path = 'asset/img/preview-imgs/icon-tick-blank1.png';
                }
            @endphp
            <img style="position:relative;margin-left:30px;" src="{{asset($img_path)}}" mchecked="false">
            <span style="font-size:23px;color:#6B6B6B;">Flexible</span>
            <input type="hidden" class="form-check-input" id="flexible" value="{{$booking->flexible}}">
        </div>
        @include('booking.summary.time')
    </div>
    <div class="calendar">
        @include('booking.summary.crew')
        <div class="contain-calendar">
            @include('booking.summary.calendar')
        </div>
    </div>

    <div class="price">
        <div>
            @include('booking.summary.price')
        </div>
        <div>
            <form action="/booking/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data" style="width: 100%">
                {{ csrf_field() }}
                <div style="width: 100%; display: flex; align-items: center; padding: 30px;">
                    @php
                        if (isset($charges['reservation_fee'])) {
                            $mobilization_charges = $charges['mob_charges'] + $charges['reservation_fee'];
                        } else {
                            $mobilization_charges = $charges['mob_charges'];
                        }

                        $additional_charges = (isset($charges['additional_charges'])) ? $charges['additional_charges'] : 0;
                    @endphp
                    <input type="hidden" name="mobilization_charges" value="{{$mobilization_charges}}">
                    <input type="hidden" name="crew_charges" value="{{$charges['total_crew_charge']}}">
                    <input type="hidden" name="additional_charges" value="{{$additional_charges}}">
                    <input type="hidden" name="insurance_charges" value="0">
                    @php 
                    if($charges['difficulty_level']=="level-4"||$charges['difficulty_level']=="level-5") { 
                    @endphp
                    <button  class="button icon book-now-btn btn-7a" id="saveBookinfff"  value="7"
                        style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" type="button">
                        <div id="circle" class="circle"></div> Book Now
                    </button> 
                    
                    
                    @php  
                } else {
                    @endphp
                     <button id="button-1" class="button icon book-now-btn btn-7a" name="btn_submit" value="7"
                        style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" type="submit">
                        <div id="circle" class="circle"></div> Book Now
                    </button>
                    @php  
            }
             @endphp
                </div>
            </form>
            
            <div class="modal fade" id="saveBookinfffmodel" tabindex="-1" role="dialog" aria-labelledby="saveBookinfffmodel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="exampleModalLabel">Save Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <div class="row container">
                   <form style="width: 100%" method="post" action="{{url('save-user-details')}}">
                   <div class="row col-md-12">
                     {{ csrf_field() }}
                     <input type="" name="booking_id" value="{{ Request::segment(2) }}" hidden>
                    <div class="col-md-12">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Mobile Number</label>
                        <input type="text" name="mobileno" class="form-control" required>
                    </div>
                   </div>
                   <div class="row mt-5 col-md-12">
                    <div class="col-md-12">
                   <button type="submit" class="btn-primary">Save</button>
                   </div>
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@include('booking.summary.inventory')
@endsection
<script src="{{asset('asset/booking/inventory.js')}}"></script>
<script src="{{asset('switchery-master/dist/switchery.min.js')}}"></script>

@section("scripts")
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
{{-- notiflix plugin for popup --}}
<script src="{{asset('asset/notiflix/notiflix-2.3.1.min.js')}}"></script>
<script src="{{asset('asset/notiflix/notiflix-aio-2.3.1.min.js')}}"></script>
<script>
    var working_hours = @json($working_hours);
    var booking_id = {{$booking->booking_id}};
    @isset($show_alert)
    Notiflix.Report.Warning(
        'Confirmation',
        'We will get back to you with a confirmation' + ' Reason: {{$reason}}',
        'Okay'
    );
    @endisset
    // @if($date_recommending)
    // Notiflix.Confirm.Init({
    //     backgroundColor:"#ffffff",
    //     fontFamily:"Quicksand",
    //     useGoogleFont:true,
    // });
    // Notiflix.Confirm.Show(
    //     'Recommendataion Booking Date',
    //     'Recommended Booking Date:<br><br> {{$recommended_data['booking_date']}} {{$recommended_data['start_time']}} ~ {{$recommended_data['end_time']}}',
    //     'Yes',
    //     'No',
    //     function() {
    //         $.ajax({
    //             url: '/save_recommended_date/' + '{{$booking->booking_id}}',
    //             type: 'GET',
    //             data: {
    //                 date: '{{$recommended_data['booking_date']}}',
    //                 start_time: '{{$recommended_data['start_time']}}',
    //                 end_time: '{{$recommended_data['end_time']}}'
    //             },
    //             success: function(data, textStatus, jqXHR) {
    //                 if (textStatus == 'success') {
    //                     Notiflix.Loading.Hourglass('Loading...');
    //                     window.location.reload();
    //                 }
    //             }
    //         })
    //     },
    //     function() {
    //         // function when click no button
    //     }
    // );
    // @endif
</script>

<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script>
<script src="{{asset('assets_admin/js/main/summary.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".check-flex img").click(function () {
            if ($(this).attr("mchecked") == "true") {
                $(this).attr("src", "{{asset('asset/img/preview-imgs/icon-tick-blank1.png')}}");
                $(this).attr("mchecked", "false");
                $('#flexible').val(0);
            } else {
                $(this).attr("src", "{{asset('asset/img/preview-imgs/icon-tick1.png')}}");
                $(this).attr("mchecked", "true");
                $('#flexible').val(1);
            }
        });

        $(".crew").on('click', function() {
            $("span.float-right").html('Loading...');
        })

    })
</script>
<script src="{{asset('asset/booking/preview.js')}}"></script>
@endsection