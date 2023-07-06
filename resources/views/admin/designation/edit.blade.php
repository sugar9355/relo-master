@extends('admin.layout.base')


@section('title', 'Update Designation ')

@section('content')

    <div class="card">
        <div class="card-body">
            
            
            @if($errors->any())
                {{ implode('', $errors->all('<div>:message</div>')) }}
            @endif

            <h3>Update Badge</h3>
            <hr>

            <form action="{{route('admin.designation.update', $designation->id)}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-row">
                    <div class="col-md-8 row">
                        <div class="form-group col-md-4">
                            <label for="name" class="form-label">@lang('admin.name')</label>
                            <input class="form-control" type="text" value="{{$designation->name}}" name="name" required id="name" placeholder="Name">
                        </div>
    
                        <div class="form-group col-md-4">
                            <label for="bonus" class="form-label">Bonus Amount</label>
                            <input class="form-control" type="text" name="bonus" value="{{isset($designation->bonus) ? $designation->bonus : null}}" id="bonus" placeholder="Bonus Amount">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="level" class="form-label">Badge Type</label>
                            <select class="form-control select" id="badge_type" name="badge_type" required>
                                <option></option>
                            @if(isset($badge_types[0]))
                            @foreach($badge_types as $type)
                                <option value="{{$type->badge_type_id}}" @if($designation->badge_type == $type->badge_type_id)selected @endif>{{$type->badge_type_name}}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>

                        {{-- designations option box --}}
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Available Roles</label>
                            <select id="roles" name="roles[]" class="form-control select" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}" @if(in_array($role->id, explode(',', $designation->roles)))selected @endif>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- description box --}}
                        <div class="col-md-12">
                            <label class="mt-1">Description</label>
                            <span class="input-group-prepend">
                                <textarea name="description" class="form-control form-control-lg" rows="3">{{isset($designation->description) ? $designation->description : null}}</textarea>
                            </span>
                        </div>
                    </div>

                    {{-- image box --}}
                    <div class="col-md-3 ml-5">
                        <!-- Photos from Flickr -->
                        <div class="card-img-actions" >
                        @if($designation->image_path == '')
                            <a href="/no_item.jpg" data-popup="lightbox"><img class="card-img img-fluid" src="/no_item.jpg" alt=""><span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span></a>
                        @else
                            <a href="{{$designation->image_path}}" data-popup="lightbox"><img class="card-img img-fluid" src="{{$designation->image_path}}" alt=""><span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span></a>
                        @endif
                        </div>
                        <!-- /photos from Flickr -->
                        <!-- Seamless button group -->
                        <div class="mb-3">
                            <div class="row row-tile no-gutters">
                                <button type="button" class="btn btn-light btn-block btn-float m-0 mb-1" data-toggle="modal" data-target="#upload_picture">
                                    <i class="icon-file-picture text-blue-400 icon-2x"></i>
                                    <span>Upload</span>
                                </button>
                            </div>
                        </div>
                        <!-- /seamless button group -->
                    </div>

                </div>

                {{-- options --}}
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label text-capitalize">options</label>
                            <select id="options" name="options[]" class="form-control select" data-container-css-class="bg-teal-400" multiple required>
                                <option value="weight" class="text-capitalize" @if(in_array('weight', explode(',', $designation->options)))selected @endif>weight</option>
                                <option value="volumetric_capacity" class="text-capitalize" @if(in_array('volumetric_capacity', explode(',', $designation->options)))selected @endif>volumetric capacity</option>
                                <option value="insurance_amount" class="text-capitalize" @if(in_array('insurance_amount', explode(',', $designation->options)))selected @endif>insurance amount</option>
                                <option value="dis_assembly" class="text-capitalize" @if(in_array('dis_assembly', explode(',', $designation->options)))selected @endif>dis-assembly</option>
                                <option value="packaging" class="text-capitalize" @if(in_array('packaging', explode(',', $designation->options)))selected @endif>packaging</option>
                                <option value="hoisting" class="text-capitalize" @if(in_array('hoisting', explode(',', $designation->options)))selected @endif>hoisting</option>
                                <option value="stairs" class="text-capitalize" @if(in_array('stairs', explode(',', $designation->options)))selected @endif>stairs</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- weight option box --}}
                <div class="form-row" id="weight-box" style="@if(!isset($designation->weight))display: none @endif">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Weight)</label>
                                    <input class="form-control" type="number" id="wei_min" name="wei_min" value="{{$designation->wei_min}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Weight)</label>
                                    <input class="form-control" type="number" id="wei_max" name="wei_max" value="{{$designation->wei_max}}">
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
                                <input id="weight" name="weight" type="hidden" value="@isset($designation->weight){{$designation->weight}} @endisset">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- volumetric_capacity option box --}}
                <div class="form-row" id="volumetric_capacity-box" style="@if(!isset($designation->volumetric_capacity))display: none @endif">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Volumetric Capacity)</label>
                                    <input class="form-control" type="number" id="vc_min" name="volumetric_capacity_min" value="{{$designation->volumetric_capacity_min}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Volumetric Capacity)</label>
                                    <input class="form-control" type="number" id="vc_max" name="volumetric_capacity_max" value="{{$designation->volumetric_capacity_max}}">
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
                                <input id="volumetric_capacity" name="volumetric_capacity" type="hidden" value="@isset($designation->volumetric_capacity){{$designation->volumetric_capacity}}@endisset">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- insurance_amount option box --}}
                <div class="form-row" id="insurance_amount-box" style="@if(!isset($designation->insurance_amount))display: none @endif">
                    <div class="col-md-6">
                        <div class="row ml-3">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Min (Insurance Amount)</label>
                                    <input class="form-control" type="number" id="ia_min" name="insurance_amount_min" value="{{$designation->insurance_amount_min}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Max (Insurance Amount)</label>
                                    <input class="form-control" type="number" id="ia_max" name="insurance_amount_max" value="{{$designation->insurance_amount_max}}">
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
                                <input id="insurance_amount" name="insurance_amount" type="hidden" value="@isset($designation->insurance_amount){{$designation->insurance_amount}}@endisset">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- dis-assembly option box --}}
                <div class="form-row" id="dis_assembly-box" style="@if(!isset($designation->dis_assembly))display: none @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Dis-Assembly</label>
                            <select id="dis_assembly" name="dis_assembly[]" class="form-control select" data-container-css-class="bg-blue-400" multiple>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{$i}}" @if(in_array($i, explode(',', $designation->dis_assembly)))selected @endif>Level-{{$i}}</option>
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
                <div class="form-row" id="hoisting-box" style="@if(!isset($designation->hoisting) || empty($designation->hoisting))display: none @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Hoisting</label>
                            <input type="text" name="hoisting" id="hoisting" class="form-control" placeholder="Hoisting" style="width: 200px" value="{{$designation->hoisting}}" />
                        </div>
                    </div>
                </div>

                {{-- stairs option box --}}
                <div class="form-row" id="stairs-box" style="@if(!isset($designation->stairs))display: none @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-12 col-form-label">Stairs</label>
                            <select id="stairs" name="stairs[]" class="form-control select" data-container-css-class="bg-blue-400" multiple>
                                <option value="wide" @if (in_array('wide', explode(',', $designation->stairs)))
                                    selected
                                @endif>wide</option>
                                <option value="windy" @if (in_array('windy', explode(',', $designation->stairs)))
                                    selected
                                @endif>windy</option>
                                <option value="spiral" @if (in_array('spiral', explode(',', $designation->stairs)))
                                    selected
                                @endif>spiral</option>
                                <option value="narrow" @if (in_array('narrow', explode(',', $designation->stairs)))
                                    selected
                                @endif>narrow</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="btn btn-primary">Update Badge</button>
                    <a href="{{route('admin.designation.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                </div>
            </form>

            <!-- Modal -->
            <div id="upload_picture" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload Items Picture / Excel</h4>
                            <a href="{{ route('admin.designation.edit', $designation->id) }}" class="close" >&times;</a>
                        </div>
                        <div class="modal-body">
                            <!-- Dropzone -->
                            <form class="dropzone" id="dropzone_single" action="{{route('admin.designation.update', $designation->id)}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PATCH">
                            </form>
                            <!-- /dropzone -->
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('admin.designation.edit', $designation->id) }}" class="btn btn-default">Done</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('scripts')
<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/media/fancybox.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/blog_single.js')}}"></script>
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
    set_values(parseInt($('#wei_min').val()), parseInt($('#wei_max').val()), '#wei_values');
    set_values(parseInt($('#vc_min').val()), parseInt($('#vc_max').val()), '#vc_values');
    set_values(parseInt($('#ia_min').val()), parseInt($('#ia_max').val()), '#ia_values');

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
            @if(isset($designation->weight) && !empty($designation->weight))
            values : [{{explode('-',$designation->weight)[0]}}, {{explode('-',$designation->weight)[1]}}],
            @endif
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
            @if(isset($designation->volumetric_capacity) && !empty($designation->volumetric_capacity))
            values : [{{explode('-',$designation->volumetric_capacity)[0]}}, {{explode('-',$designation->volumetric_capacity)[1]}}],
            @endif
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
            @if(isset($designation->insurance_amount) && !empty($designation->insurance_amount))
            values : [{{explode('-',$designation->insurance_amount)[0]}}, {{explode('-',$designation->insurance_amount)[1]}}],
            @endif
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