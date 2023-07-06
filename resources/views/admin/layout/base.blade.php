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


    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    
    <link href="{{asset('assets_admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/extras/hover-min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/extras/animate.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('assets_admin/js/plugins/visualization/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/daterangepicker.js')}}"></script>

    <script src="{{asset('assets_admin/js/app.js')}}"></script>
    <script src="{{asset('assets_admin/js/demo_pages/dashboard.js')}}"></script>

    <script src="{{asset('assets_admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/demo_pages/datatables_advanced.js')}}"></script>

    <script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
    
    <script src="{{asset('assets_admin/js/plugins/forms/styling/switch.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/demo_pages/form_checkboxes_radios.js')}}"></script>
    <script src="{{asset('assets_admin/js/demo_pages/form_inputs.js')}}"></script>
    <!-- /theme JS files -->



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



    <!-- Main navbar -->
    @include('admin.include.header')
    <!-- /main navbar -->



    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
       @include('admin.include.nav')
        <!-- /main sidebar -->

		@include('admin.include.lay')
        
            <!-- Content area -->
            <div class="content">

                
                    @include('common.notify')

                    @yield('content')


            </div>
            <!-- /content area -->


            <!-- Footer -->
            @include('admin.include.footer')
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->










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
<script>
    $.ajax({
        url: '{{ route('admin.getRadius') }}',
        type: 'GET',
        success: function(data, textStatus, jqXHR){
            $('#distance_radius').val(data);
        }
    })
</script>

</body>
</html>
