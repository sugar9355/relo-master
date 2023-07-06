@extends('admin.layout.base')

@section('title', 'Add Packing Supplies ')

@section('content')
<div class="card">
    <div class="card-header bg-dark">
        <h5 class="card-title">Packing Supplies</h5>
    </div>
    <div class="card-body">

        <form class="form-horizontal" action="{{route('admin.supply.store')}}" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}

            <div class="row">
                <div class="col-2 pl-3 form-group">
                    <label class="mt-1">Name</label>
                    <input class="form-control" type="text" name="name" id="name" required>
                </div>
            </div>
            <div class="row">
                <div class="col-2 pl-3 form-group">
                    <label class="mt-1">Cost Per (<span id="packing_name"></span>)</label>
                    <input class="form-control" type="text" name="cost" id="cost" required>
                </div>
            </div>
            <div class="form-group">
                <hr>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane"></i></button>
                    <a href="{{route('admin.supply.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
@section('scripts')
<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/form_multiselect.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/inputs/touchspin.min.js')}}"></script>

<script src="{{asset('assets_admin/js/demo_pages/form_input_groups.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
<!-- /theme JS files -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places" type="text/javascript" ></script>

<script>
    jQuery(document).ready(function() {
        $('#name').keyup(function() {
            $('#packing_name').html($(this).val())
        })
    })

</script>
@endsection