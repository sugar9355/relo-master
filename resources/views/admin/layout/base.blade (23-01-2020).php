<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>@yield('title'){{ Setting::get('site_title', 'Tranxit') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}">

    <!-- 
	Vendor CSS 
	-->
	
    <link rel="stylesheet" href="{{asset('main/vendor/bootstrap4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/themify-icons/themify-icons.css')}}">
    <!--  
	<link rel="stylesheet" href="{{asset('main/vendor/font-awesome/css/font-awesome.min.css')}}"> -->
    <link rel="stylesheet" href="{{asset('main/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/jscrollpane/jquery.jscrollpane.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/waves/waves.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/switchery/dist/switchery.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Buttons/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <link rel="stylesheet" href="/farbtastic/farbtastic.css">
    <link rel="stylesheet" href="{{ asset('main/assets/css/core.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Global stylesheets 
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	
	<link href="{{asset('celender/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('celender/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('celender/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('celender/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('celender/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->


    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style type="text/css">
        .rating-outer span,
        .rating-symbol-background {
            color: #ffe000!important;
        }
        .rating-outer span,
        .rating-symbol-foreground {
            color: #ffe000!important;
        }
    </style>
    @yield('styles')
</head>
<body class="fixed-sidebar fixed-header content-appear skin-default">

<div class="wrapper">
    <div class="preloader"></div>
    <div class="site-overlay"></div>

    @include('admin.include.nav')

    @include('admin.include.header')

    <div class="site-content">

        @include('common.notify')

        @yield('content')

        @include('admin.include.footer')

    </div>
</div>

<!-- Vendor JS -->
<script type="text/javascript" src="{{asset('main/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
{{--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.7/js/tether.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/bootstrap4/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/detectmobilebrowser/detectmobilebrowser.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/jscrollpane/jquery.mousewheel.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/jscrollpane/mwheelIntent.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/jscrollpane/jquery.jscrollpane.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/jquery-fullscreen-plugin/jquery.fullscreen')}}-min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/waves/waves.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Responsive/js/dataTables.responsi')}}ve.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Responsive/js/responsive.bootstra')}}p4.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/dataTables.buttons')}}.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.bootstrap4')}}.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/JSZip/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/pdfmake/build/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/pdfmake/build/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.html5.min.js')}}"></script>

<script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/DataTables/Buttons/js/buttons.colVis.min.js')}}"></script>

<script type="text/javascript" src="{{asset('main/vendor/switchery/dist/switchery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/dropify/dist/js/dropify.min.js')}}"></script>

<script type="text/javascript" src="{{asset('main/vendor/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

<!-- Neptune JS -->
<script type="text/javascript" src="{{asset('main/assets/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/demo.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/forms-pickers.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/tables-datatable.js')}}"></script>
<script type="text/javascript" src="{{asset('main/assets/js/forms-upload.js')}}"></script>
<script type="text/javascript" src="/farbtastic/farbtastic.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script>
    $(function(){
        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        try {
            $("#select2").select2();
            $("#select1").select2();
            $("#select3").select2();
            let selectedValues = $("#select2Val").val().split(',');
            $("#select1").val(selectedValues).trigger('change');
            $("#select1").attr('disabled', true);
            let last_valid_selection = selectedValues;
            $('#select1').change(function(event) {
                if ($(this).val()){
                    if ($(this).val().length > 2) {
                        $(this).val(last_valid_selection).trigger('change');
                    } else {
                        last_valid_selection = $(this).val();
                    }
                }
            });
        }catch (e) {}
        $("#sticker_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        $("#sticker_due_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        $("#fuel_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        $("#fuel_due_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        $("#service_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        $("#service_due_date").datepicker({
            format: 'yyyy-mm-dd',
        });
        try{
            $('#colorpicker').farbtastic('#color');
        }catch(ex){
            // console.log(ex);
        }
        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date == "undefined" && to_date == "undefined")
            {
                alert("Please Select Date");
            }
            else
            {
                $.ajax({
                    url:"filter.php",
                    method:"POST",
                    data:{from_date:from_date, to_date:to_date},
                    success:function(data)
                    {
                        $('#table-2').html(data);
                    }
                });
            }
        });
    });
</script>


@yield('scripts')

<script type="text/javascript" src="{{asset('asset/js/rating.js')}}"></script>
<script type="text/javascript">
    $('.rating').rating();
</script>

@if(Setting::get('demo_mode', 0) == 1)
    <!-- Start of LiveChat (www.livechatinc.com) code -->
    <script type="text/javascript">
        window.__lc = window.__lc || {};
        window.__lc.license = 8256261;
        (function() {
            var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
            lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
    </script>
    <!-- End of LiveChat code -->
@endif

</body>
</html>
