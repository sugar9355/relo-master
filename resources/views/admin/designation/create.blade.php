@extends('admin.layout.base')


@section('title', 'Add Designation ')

@section('content')

    <div class="card">
        <div class="card-body">
            
            
            @if($errors->any())
                {{ implode('', $errors->all('<div>:message</div>')) }}
            @endif

            <h3>Add New Badge</h3>
            <hr>

            <form action="{{route('admin.designation.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="col-md-8 row">
                        <div class="form-group col-md-4">
                            <label for="name" class="form-label">@lang('admin.name')</label>
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Name">
                        </div>
    
                        <div class="form-group col-md-4">
                            <label for="bonus" class="form-label">Bonus Amount</label>
                            <input class="form-control" type="text" name="bonus" value="{{old('bonus')}}" id="bonus" placeholder="Bonus Amount">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="level" class="form-label">Badge Type</label>
                            <select class="form-control select" id="badge_type" name="badge_type" required>
                                <option></option>
                            @if(isset($badge_types[0]))
                            @foreach($badge_types as $type)
                                <option value="{{$type->badge_type_id}}" >{{$type->badge_type_name}}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>

                        {{-- designations option box --}}
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Available Roles</label>
                            <select id="roles" name="roles[]" class="form-control select" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- description box --}}
                        <div class="col-md-12">
                            <label class="mt-1">Description</label>
                            <span class="input-group-prepend">
                                <textarea name="description" class="form-control form-control-lg" rows="3"></textarea>
                            </span>
                        </div>
                    </div>

                    {{-- image box --}}
                    <div class="col-md-3 ml-5">
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row row-tile no-gutters">
                                    <input type="file" name="file" class="file-input form-control-sm" data-show-caption="false"
                                        data-show-upload="false" data-browse-class="btn btn-primary btn-sm"
                                        data-remove-class="btn btn-light btn-sm" data-fouc>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- options --}}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label text-capitalize">options</label>
                            <select id="options" name="options[]" class="form-control select" data-container-css-class="bg-teal-400" multiple required>
                                <option value="weight" class="text-capitalize">weight</option>
                                <option value="volumetric_capacity" class="text-capitalize">volumetric capacity</option>
                                <option value="insurance_amount" class="text-capitalize">insurance amount</option>
                                <option value="dis_assembly" class="text-capitalize">dis-assembly</option>
                                <option value="packaging" class="text-capitalize">packaging</option>
                                <option value="hoisting" class="text-capitalize">hoisting</option>
                                <option value="stairs" class="text-capitalize">stairs</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- weight option box --}}
                <div class="form-row" id="weight-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Weight)</label>
                                    <input class="form-control" type="number" id="wei_min" name="wei_min" value="0">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Weight)</label>
                                    <input class="form-control" type="number" id="wei_max" name="wei_max" value="100">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pl-2 ml-3">
                            <label class="mt-1">Weight (lbs)</label>
                            <div class="row">
                                <table>
                                    <tr>
                                        <td colspan="10">
                                            <div id="wei_slider" class="slider" style="width: 600px;"></div>
                                        </td>
                                    </tr>
                                    <tr id="wei_values">
                                        @for ($i = 0; $i <= 100; $i += 10)
                                            <td style="width: 30px;">{{$i}}</td>
                                        @endfor
                                    </tr>
                                </table>
                                <input id="weight" name="weight" type="hidden" value="">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- volumetric_capacity option box --}}
                <div class="form-row" id="volumetric_capacity-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Volumetric Capacity)</label>
                                    <input class="form-control" type="number" id="vc_min" name="volumetric_capacity_min" value="0">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Volumetric Capacity)</label>
                                    <input class="form-control" type="number" id="vc_max" name="volumetric_capacity_max" value="1000">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pl-2 ml-3">
                            <label class="mt-1">Volumetric Capacity (Cm3)</label>
                            <div class="row">
                                <table>
                                    <tr>
                                        <td colspan="10">
                                            <div id="vc_slider" class="slider" style="width: 600px;"></div>
                                        </td>
                                    </tr>
                                    <tr id="vc_values">
                                        @for ($i = 0; $i <= 1000; $i += 100)
                                            <td style="width: 30px;">{{$i}}</td>
                                        @endfor
                                    </tr>
                                </table>
                                <input id="volumetric_capacity" name="volumetric_capacity" type="hidden" value="">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- insurance_amount option box --}}
                <div class="form-row" id="insurance_amount-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Insurance Amount)</label>
                                    <input class="form-control" type="number" id="ia_min" name="insurance_amount_min" value="0">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Insurance Amount)</label>
                                    <input class="form-control" type="number" id="ia_max" name="insurance_amount_max" value="1000">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pl-2 ml-3">
                            <label class="mt-1">Insurance Amount ($)</label>
                            <div class="row">
                                <table>
                                    <tr>
                                        <td colspan="10">
                                            <div id="ia_slider" class="slider" style="width: 600px;"></div>
                                        </td>
                                    </tr>
                                    <tr id="ia_values">
                                        @for ($i = 0; $i <= 1000; $i += 100)
                                            <td style="width: 30px;">{{$i}}</td>
                                        @endfor
                                    </tr>
                                </table>
                                <input id="insurance_amount" name="insurance_amount" type="hidden" value="">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- dis-assembly option box --}}
                <div class="form-row" id="dis_assembly-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Dis-Assembly</label>
                            <select id="dis_assembly" name="dis_assembly[]" class="form-control select" data-container-css-class="bg-blue-400" multiple>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{$i}}">Level-{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- packaging option box --}}
                <div class="form-row" id="packaging-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Packaging</label>
                        </div>
                    </div>
                </div>

                {{-- hoisting option box --}}
                <div class="form-row" id="hoisting-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Hoisting</label>
                            <input type="text" name="hoisting" id="hoisting" class="form-control" placeholder="Hoisting" style="width: 200px" />
                        </div>
                    </div>
                </div>

                {{-- stairs option box --}}
                <div class="form-row" id="stairs-box" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Stairs</label>
                            <select id="stairs" name="stairs[]" class="form-control select" data-container-css-class="bg-blue-400" multiple>
                                <option value="wide">wide</option>
                                <option value="windy">windy</option>
                                <option value="spiral">spiral</option>
                                <option value="narrow">narrow</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="btn btn-primary">Add Badge</button>
                    <a href="{{route('admin.designation.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
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

<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/dropzone.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/uploader_bootstrap.js')}}"></script>


{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<script type="text/javascript">
    jQuery(document).ready(function() {
        $('#badge_type').select2({
            placeholder: "Select a type",
            allowClear: true
        })

        // options select box
        $('#options').change(function() {
            var selected = $(this).val()
            if (selected.includes('weight')) {
                $('#weight-box').show()
            } else {
                $('#weight-box').hide();
                $('#wei_max').val(100).trigger('change');
                $('#wei_min').val(0).trigger('change');
                set_values(0, 100, '#wei_values');
                $("#wei_slider").slider({
                    values: [0, 0],
                });
                $('#weight').val(null).trigger('change');
            }

            if (selected.includes('volumetric_capacity')) {
                $('#volumetric_capacity-box').show()
            } else {
                $('#volumetric_capacity-box').hide()
                $('#vc_max').val(1000).trigger('change');
                $('#vc_min').val(0).trigger('change');
                set_values(0, 1000, '#vc_values');
                $("#vc_slider").slider({
                    values: [0, 0],
                });
                $('#volumetric_capacity').val(null).trigger('change');
            }

            if (selected.includes('insurance_amount')) {
                $('#insurance_amount-box').show()
            } else {
                $('#insurance_amount-box').hide()
                $('#ia_max').val(1000).trigger('change');
                $('#ia_min').val(0).trigger('change');
                set_values(0, 1000, '#ia_values');
                $("#ia_slider").slider({
                    values: [0, 0],
                });
                $('#insurance_amount').val(null).trigger('change');
            }

            if (selected.includes('dis_assembly')) {
                $('#dis_assembly-box').show()
            } else {
                $('#dis_assembly-box').hide()
                $('#dis_assembly').val(null).trigger('change')
            }

            if (selected.includes('packaging')) {
                $('#packaging-box').show()
            } else {
                $('#packaging-box').hide()
            }

            if (selected.includes('hoisting')) {
                $('#hoisting-box').show()
            } else {
                $('#hoisting-box').hide()
                $('#hoisting').val(null).trigger('change')
            }

            if (selected.includes('stairs')) {
                $('#stairs-box').show()
            } else {
                $('#stairs-box').hide()
                $('#stairs').val(null).trigger('change')
            }
        })

        // weight slider part
        $("#wei_slider").slider({
            tooltip: 'always',
            range: true,
            min: parseInt($('#wei_min').val()),
            max: parseInt($('#wei_max').val()),
            // step: ($('#wei_max').val() - $('#wei_min').val()) / 10,
            slide: function (e, ui) 
            {
                $("#weight").val(ui.values[0] +"-"+ ui.values[1]);
            }
        });

        $('#wei_min').keyup(function() {
            $("#wei_slider").slider("option", "min", parseInt($('#wei_min').val()));
            set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')
        })

        $('#wei_max').keyup(function() {
            $("#wei_slider").slider("option", "max", parseInt($('#wei_max').val()));
            set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values')
        })

        // volumetric capacity part
        $("#vc_slider").slider({
            tooltip: 'always',
            range: true,
            min: parseInt($('#vc_min').val()),
            max: parseInt($('#vc_max').val()),
            slide: function (e, ui) 
            {
                $("#volumetric_capacity").val(ui.values[0] +"-"+ ui.values[1]);
            }
        });

        $('#vc_min').keyup(function() {
            $("#vc_slider").slider("option", "min", parseInt($('#vc_min').val()));
            set_values(parseInt($('#vc_min').val()), parseInt($('#vc_max').val()), '#vc_values')
        })

        $('#vc_max').keyup(function() {
            $("#vc_slider").slider("option", "max", parseInt($('#vc_max').val()));
            set_values(parseInt($('#vc_min').val()), parseInt($('#vc_max').val()), '#vc_values')
        })

        // insuranace amount part
        $("#ia_slider").slider({
            tooltip: 'always',
            range: true,
            min: parseInt($('#ia_min').val()),
            max: parseInt($('#ia_max').val()),
            slide: function (e, ui) 
            {
                $("#insurance_amount").val(ui.values[0] +"-"+ ui.values[1]);
            }
        });

        $('#ia_min').keyup(function() {
            $("#ia_slider").slider("option", "min", parseInt($('#ia_min').val()));
            set_values(parseInt($('#ia_min').val()), parseInt($('#ia_max').val()), '#ia_values')
        })

        $('#ia_max').keyup(function() {
            $("#ia_slider").slider("option", "max", parseInt($('#ia_max').val()));
            set_values(parseInt($('#ia_min').val()), parseInt($('#ia_max').val()), '#ia_values')
        })
    })

    function set_values(min, max, id) {
        $(id).empty()
        for (var i = min;;i += (max-min)/10) {
            if (i >= max) {
                $(id).append('<td style="width: 30px;">' + max + '</td>')
                break;
            } else if (i.toFixed(0) < max) {
                $(id).append('<td style="width: 30px;">' + i.toFixed(0) + '</td>')
            }
        }
    }
</script>
@endsection