@extends('user.layout.app')
@section('meta')
<meta name="token" content="{{csrf_token()}}">
@endsection
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<link rel="stylesheet" href="{{asset('switchery-master/dist/switchery.min.css')}}">
<link rel="stylesheet" href="{{asset('asset/css/drop.css')}}">

<style>
    #summary #locations .loc-edit {

        position: absolute;

        right: 0;

        top: 0;

    }



    body {

        background-color: #fff;

        background-image: none;

    }





    .custom-control-input:checked~.custom-control-label::before {

        border-color: #fff;

        background-color: var(--info);

        top: .40rem;

        left: -1.35rem;

        display: block;

        width: .7rem;

        height: .7rem;

    }

    #summary .crew .custom-control input[type='radio']+label:after {

        top: 5rem;

        left: 5rem;

    }

    #summary .crew .custom-control input[type='radio']+label:before {

        top: 5.12rem;

        left: 5.12rem;

    }

    #summary .custom-control input[type='radio']+label strong {

        margin-bottom: 9px;

        display: block;

    }

    .custom-radio .custom-control-input:checked~.custom-control-label::after {

        background-image: none;

        border: 1.5px solid #c6c6c6;

        border-radius: 50%;

    }

    .custom-control input[type='radio']+label {

        opacity: 1;

        background-color: transparent;

        font-size: 18px;

    }

    .custom-control input[type='radio']:checked+label {

        opacity: 1;

        outline: none;

    }

    #summary #insurancebox .media {

        min-width: 190px;

    }

    #summary #insurancebox .media .btn {

        padding: 2px 5px !important;

        height: 50%;

    }

    #summary #insurancebox .media span {}

    #summary #insurancebox .media .btn:last-of-type {

        background-color: #d39e00 !important;

    }

    #chart_div {

        width: 400px;

        height: auto;

        margin: auto;

    }



    .text-orange {

        color: var(--orange)
    }

    .hvr-sweep-to-right {

        color: #ffffff;

    }

    .hvr-sweep-to-right:hover,
    .hvr-sweep-to-right:hover>*,
    .hvr-sweep-to-right:hover input[type='radio']+label:before {

        color: #ffffff !important;

        border-color: #ffffff !important;

    }

    .hvr-sweep-to-right:hover input[type='radio']+label.text-dark {

        color: #fff !important;

    }

    .hvr-sweep-to-right:hover i {

        color: var(--white);

    }

    .hvr-sweep-to-right:before {

        border-radius: 5px;

        background-color: var(--dark);

    }

    .hvr-sweep-to-right:visited {

        background-color: #333;

    }



    #summary #inventory .media {

        margin-bottom: 10px;

        border-bottom: 1px solid #eee;

    }

    #summary #inventory .media a {

        width: 100px;

    }

    #summary #inventory .media .img-fluid {

        width: auto;

        height: auto;

        max-height: 90px;

        min-width: 70%;

        margin: 5px 0px;

    }



    #summary .progress {

        overflow: unset;

        position: relative;

    }

    #summary .pricing {

        position: absolute;

        bottom: -45px;

        font-weight: bold;

        background-color: #ffffff;

        text-align: center;

        padding: 5px 10px;

        display: inline-block;

        border-radius: 5px;

        border: 1px solid #ddd;

        box-shadow: 0px 6px 16px #ddd;

    }

    span.pricing:before {

        content: '';

        left: 45%;

        border-right: 10px solid #3330;

        border-bottom: 20px solid #959595;

        border-top: 10px solid #45393900;

        border-left: 10px solid #95959500;

        height: 0;

        width: 0;

        display: block;

        position: absolute;

        top: -31px;

    }



    .recomended {

        width: 100%;

        border: none;

    }



    /*.loc-points .col:after{
  
    content: '\f30b';
  
    font-family: "Font Awesome 5 Pro";
  
    font-weight: 900;
  
    position: absolute;
  
    left: 0;
  
  }*/



    .total-a {

        position: absolute;

        bottom: 15px;

        width: 100%;

    }



    .form-control {

        display: block;

        width: 100%;

        height: calc(1.8em + .75rem + 2px);

        padding: .375rem .75rem;

        font-size: 1rem;

        font-weight: 400;

        line-height: 1.5;

        color: #495057;

        background-color: #fff;

        background-clip: padding-box;

        border: 1px solid #a9a9a9;

        border-radius: .25rem;

        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

    }



    .nav-tabs {

        padding: 8px;

        width: 80%;

        border-radius: 30px;

        background-color: var(--warning);

    }

    .nav-tabs a.active,
    .nav-tabs a.active:hover,
    .nav-tabs a.active:focus {

        color: var(--warning) !important;

        border-radius: 30px;

        background-color: #ffffff !important;

        border: none !important;

        box-shadow: 1px 4px 6px #cf9c03;

    }

    .nav-tabs a {

        color: #fff;

        font-weight: 500;

        font-size: 18px;

        margin-right: 5px;

        border-radius: 30px !important;

    }





    .charges {

        background: rgba(96, 96, 96, 1);

        background: -moz-linear-gradient(-45deg, rgba(96, 96, 96, 1) 0%, rgba(45, 45, 45, 1) 100%);

        background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(96, 96, 96, 1)), color-stop(100%, rgba(45, 45, 45, 1)));

        background: -webkit-linear-gradient(-45deg, rgba(96, 96, 96, 1) 0%, rgba(45, 45, 45, 1) 100%);

        background: -o-linear-gradient(-45deg, rgba(96, 96, 96, 1) 0%, rgba(45, 45, 45, 1) 100%);

        background: -ms-linear-gradient(-45deg, rgba(96, 96, 96, 1) 0%, rgba(45, 45, 45, 1) 100%);

        background: linear-gradient(135deg, rgba(96, 96, 96, 1) 0%, rgba(45, 45, 45, 1) 100%);

        filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#606060', endColorstr='#2d2d2d', GradientType=1);

        color: #FFC107 !important;

        font-weight: 600 !important;

        border-radius: 10px !important;

        border: none !important;

    }

    .charges h5 {

        font-weight: 600;

        border-color: #FFC107 !important;

    }

    .charges * {

        text-shadow: 0px 3px 6px rgba(0, 0, 0, .16);

        border-color: #FFC107 !important;

    }
    .pure-material-textfield-outlined {
    --pure-material-safari-helper1: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    position: relative;
    display: inline-block;
    padding-top: 6px;
    font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
    font-size: 16px;
    line-height: 1.5;
    overflow: hidden;
}

/* Input, Textarea */
.pure-material-textfield-outlined > input,
.pure-material-textfield-outlined > textarea {
    box-sizing: border-box;
    margin: 0;
    border: solid 1px; /* Safari */
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    border-top-color: transparent;
    border-radius: 4px;
    padding: 15px 13px 15px;
    width: 100%;
    height: inherit;
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
    background-color: transparent;
    box-shadow: none; /* Firefox */
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    caret-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    transition: border 0.2s, box-shadow 0.2s;
}

/* Span */
.pure-material-textfield-outlined > input + span,
.pure-material-textfield-outlined > textarea + span {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    width: 100%;
    max-height: 100%;
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    font-size: 75%;
    line-height: 15px;
    cursor: text;
    transition: color 0.2s, font-size 0.2s, line-height 0.2s;
}

/* Corners */
.pure-material-textfield-outlined > input + span::before,
.pure-material-textfield-outlined > input + span::after,
.pure-material-textfield-outlined > textarea + span::before,
.pure-material-textfield-outlined > textarea + span::after {
    content: "";
    display: block;
    box-sizing: border-box;
    margin-top: 6px;
    border-top: solid 1px;
    border-top-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    min-width: 10px;
    height: 8px;
    pointer-events: none;
    box-shadow: inset 0 1px transparent;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.pure-material-textfield-outlined > input + span::before,
.pure-material-textfield-outlined > textarea + span::before {
    margin-right: 4px;
    border-left: solid 1px transparent;
    border-radius: 4px 0;
}

.pure-material-textfield-outlined > input + span::after,
.pure-material-textfield-outlined > textarea + span::after {
    flex-grow: 1;
    margin-left: 4px;
    border-right: solid 1px transparent;
    border-radius: 0 4px;
}

/* Hover */
.pure-material-textfield-outlined:hover > input,
.pure-material-textfield-outlined:hover > textarea {
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
    border-top-color: transparent;
}

.pure-material-textfield-outlined:hover > input + span::before,
.pure-material-textfield-outlined:hover > textarea + span::before,
.pure-material-textfield-outlined:hover > input + span::after,
.pure-material-textfield-outlined:hover > textarea + span::after {
    border-top-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
}

.pure-material-textfield-outlined:hover > input:not(:focus):placeholder-shown,
.pure-material-textfield-outlined:hover > textarea:not(:focus):placeholder-shown {
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
}

/* Placeholder-shown */
.pure-material-textfield-outlined > input:not(:focus):placeholder-shown,
.pure-material-textfield-outlined > textarea:not(:focus):placeholder-shown {
    border-top-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
}

.pure-material-textfield-outlined > input:not(:focus):placeholder-shown + span,
.pure-material-textfield-outlined > textarea:not(:focus):placeholder-shown + span {
    font-size: inherit;
    line-height: 68px;
}

.pure-material-textfield-outlined > input:not(:focus):placeholder-shown + span::before,
.pure-material-textfield-outlined > textarea:not(:focus):placeholder-shown + span::before,
.pure-material-textfield-outlined > input:not(:focus):placeholder-shown + span::after,
.pure-material-textfield-outlined > textarea:not(:focus):placeholder-shown + span::after {
    border-top-color: transparent;
}

/* Focus */
.pure-material-textfield-outlined > input:focus,
.pure-material-textfield-outlined > textarea:focus {
    border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    border-top-color: transparent;
    box-shadow: inset 1px 0 var(--pure-material-safari-helper1), inset -1px 0 var(--pure-material-safari-helper1), inset 0 -1px var(--pure-material-safari-helper1);
    outline: none;
}

.pure-material-textfield-outlined > input:focus + span,
.pure-material-textfield-outlined > textarea:focus + span {
    color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
}

.pure-material-textfield-outlined > input:focus + span::before,
.pure-material-textfield-outlined > input:focus + span::after,
.pure-material-textfield-outlined > textarea:focus + span::before,
.pure-material-textfield-outlined > textarea:focus + span::after {
    border-top-color: var(--pure-material-safari-helper1) !important;
    box-shadow: inset 0 1px var(--pure-material-safari-helper1);
}

/* Disabled */
.pure-material-textfield-outlined > input:disabled,
.pure-material-textfield-outlined > input:disabled + span,
.pure-material-textfield-outlined > textarea:disabled,
.pure-material-textfield-outlined > textarea:disabled + span {
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38) !important;
    border-top-color: transparent !important;
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
    pointer-events: none;
}

.pure-material-textfield-outlined > input:disabled + span::before,
.pure-material-textfield-outlined > input:disabled + span::after,
.pure-material-textfield-outlined > textarea:disabled + span::before,
.pure-material-textfield-outlined > textarea:disabled + span::after {
    border-top-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38) !important;
}

.pure-material-textfield-outlined > input:disabled:placeholder-shown,
.pure-material-textfield-outlined > input:disabled:placeholder-shown + span,
.pure-material-textfield-outlined > textarea:disabled:placeholder-shown,
.pure-material-textfield-outlined > textarea:disabled:placeholder-shown + span {
    border-top-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38) !important;
}

.pure-material-textfield-outlined > input:disabled:placeholder-shown + span::before,
.pure-material-textfield-outlined > input:disabled:placeholder-shown + span::after,
.pure-material-textfield-outlined > textarea:disabled:placeholder-shown + span::before,
.pure-material-textfield-outlined > textarea:disabled:placeholder-shown + span::after {
    border-top-color: transparent !important;
}

/* Faster transition in Safari for less noticable fractional font-size issue */
@media not all and (min-resolution:.001dpcm) {
    @supports (-webkit-appearance:none) {
        .pure-material-textfield-outlined > input,
        .pure-material-textfield-outlined > input + span,
        .pure-material-textfield-outlined > textarea,
        .pure-material-textfield-outlined > textarea + span,
        .pure-material-textfield-outlined > input + span::before,
        .pure-material-textfield-outlined > input + span::after,
        .pure-material-textfield-outlined > textarea + span::before,
        .pure-material-textfield-outlined > textarea + span::after {
            transition-duration: 0.1s;
        }
    }
}



</style>
@section('content')
<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data" style="width: 100%">
{{ csrf_field() }}
<div class="container-fluid">
    <div class="row mt-5">
        {{-- @include('booking.final.insurance') --}}
        @include('booking.final.information')
        <div class="col-md-5">
            @include('booking.final.billing_addy')
            @include('booking.final.charges')
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <button type="submit" name="btn_submit" value="0" class="btn btn-dark m-auto hvr-icon-wobble-horizontal animated slideInRight">Submit</button>
    </div>
</div>
</form>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{asset('asset/js/drop.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        $('#save_loc').on('click', function() {
            $.ajax({
                type: "POST",
                url: "/save_loc",
                data: {
                    _token: $('meta[name="token"]').attr('content'),
                    booking_id: '{{$booking->booking_id}}',
                    first_name: $('#n_b_fn').val(),
                    last_name: $('#n_b_ln').val(),
                    phone_number: $('#n_b_pn').val(),
                    email: $('#n_b_em').val(),
                    street: $('#n_b_st').val(),
                    city: $('#n_b_ct').val(),
                    state: $('#n_b_state').val(),
                    zipcode: $('#n_b_zc').val(),
                    apt: $('#n_b_apt').val()
                },
                success: function(data) {
                    if (data == 'input_error') {
                        alert('Please input correctly')
                    } else {
                        var res = '<div class="bg-white p-2 rounded border"><div class="form-check"><input type="checkbox" class="form-check-input b_l" name="billing_addy[]" value=""><label class="form-check-label" for="">' + data + '</label></div></div>';
                        $('#locations').append(res);
                        $("#add-loc-pop").modal("hide");
                        $('.b_l').on('change', function() {
                            $('.b_l').prop('checked', false)
                            $(this).prop('checked', true)
                        })
                    }
                }
            })
        })

        $('.b_l').on('change', function() {
            $('.b_l').prop('checked', false)
            $(this).prop('checked', true)
        })

        $('.state').click(function() {
            let state = ($(this).data('value'))
            $('#per_state').val(state)
        })
    })
</script>
