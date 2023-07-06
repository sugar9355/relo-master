@extends('user.layout.app')

@section('styles')
{{-- notiflix plugin for the popup --}}
<link rel="stylesheet" href="{{asset('asset/notiflix/notiflix-2.3.1.min.css')}}">
<link rel="stylesheet" href="{{asset('asset/css/style-preview.css')}}">
<style>.cursor{ cursor: pointer;}</style>
@endsection

@section('content')

    @include('booking.summary.style.summary')
    @include('booking.summary.style.slider')

    <section class="content" id="summary">

    @include('booking.summary.location')

    <div class="container-fluid">

        @include('booking.summary.crew')

        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="flexible" value="{{$booking->flexible}}" @if($booking->flexible == 1)checked @endif>
                    <label class="form-check-label text-primary" for="flexible">Flexible</label>
                </div>
            </div>
        </div>
        <div class="row">

            @include('booking.summary.calendar')

            <div id="pricing_date_time" class="col-md-6 mt-3">
            
                @include('booking.summary.pricing_date_time')
            
            </div>
            
            <div class="col-md-12">
            
                @include('booking.summary.inventory')
                
            </div>
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
                    <button type="submit" name="btn_submit" value="7" class="btn btn-dark m-auto hvr-icon-wobble-horizontal animated slideInRight">Proceed <i class="fas fa-chevron-right hvr-icon"></i></button>
                </div>
            </form>
        </div>

    </div>
    
    @include('booking.summary.modal.modal_time')

    </section>

@endsection

@section("scripts")
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
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
    @if($date_recommending)
    Notiflix.Confirm.Init({
        backgroundColor:"#ffffff",
        fontFamily:"Quicksand",
        useGoogleFont:true,
    });
    Notiflix.Confirm.Show(
        'Recommendataion Booking Date',
        'Recommended Booking Date:<br><br> {{$recommended_data['booking_date']}} {{$recommended_data['start_time']}} ~ {{$recommended_data['end_time']}}',
        'Yes',
        'No',
        function() {
            $.ajax({
                url: '/save_recommended_date/' + '{{$booking->booking_id}}',
                type: 'GET',
                data: {
                    date: '{{$recommended_data['booking_date']}}',
                    start_time: '{{$recommended_data['start_time']}}',
                    end_time: '{{$recommended_data['end_time']}}'
                },
                success: function(data, textStatus, jqXHR) {
                    if (textStatus == 'success') {
                        Notiflix.Loading.Hourglass('Loading...');
                        window.location.reload();
                    }
                }
            })
        },
        function() {
            // function when click no button
        }
    );
    @endif
</script> 

<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script> 
<script src="{{asset('assets_admin/js/main/summary.js')}}"></script> 
<script>
    $(document).ready(function() {
        $(".crew").on('click', function() {
            $("span.float-right").html('Loading...');
        })
        $('#flexible').change(function() {
            if (this.checked) {
                $(this).val(1)
            } else {
                $(this).val(0)
            }
        })
    })
</script>
@endsection