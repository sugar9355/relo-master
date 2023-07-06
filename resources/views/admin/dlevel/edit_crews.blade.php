@extends('admin.layout.base')

@section('title', 'Edit Crew Combination ')

@section('content')
    <div class="card">
        <div class="card-header bg-dark">
            <h4 class="card-title">Crew Combination</h4>
        </div>

        <div class="card-body">
            <div class="row">
                @php
                    $roles = explode(',', $c_c_data->roles);
                    $levels = explode(',', $c_c_data->levels);
                @endphp

                <div class="col-md-12">
                <form action="{{route('admin.save_crew_updates')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="c_c_id" value="{{$c_c_data->id}}">

                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>Role</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $k => $role)
                            <tr id="crew_{{$k}}">
                                <td>
                                    <select name="roles[{{$k}}]" class="form-control select" data-container-css-class="bg-info-400 text-light">
                                        <option value="0">Select a Role... </option>
                                        @foreach ($all_roles as $r)
                                            <option value="{{$r->id}}" @if ($r->id == $role)
                                                selected
                                            @endif>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="levels[{{$k}}]" class="form-control select" data-container-css-class="bg-orange-400">
                                        <option value="0">Select a Level... </option>
                                        @foreach ($all_levels as $l)
                                            <option value="{{$l->id}}" @if ($l->id == $levels[$k])
                                                selected
                                            @endif>{{$l->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger delete_crew" value="{{$k}}" onclick="remove({{$k}})"><i class="icon-trash"></i> Remove</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary mt-2" id="add_crew" name="add_crew" value="{{count($roles)}}"><i class="icon-plus3"></i> Add new</button>

                    <hr>

                    <button type="submit" class="btn btn-info"> Save updates</button>
                </form>
                </div>
            </div>
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
    <script>
        jQuery(document).ready(function() {
            $('#add_crew').click(function() {
                var index = $(this).val()
                $(this).val(parseInt(index) + 1)
                var res = `<tr id="crew_${index}"><td>`
                res += `<select name="roles[${index}]" class="form-control select" data-container-css-class="bg-info-400 text-right">`
                res += `<option value="0">Select a Role...</option>`
                
                @foreach ($all_roles as $r)
                res += `<option value="{{$r->id}}">{{$r->name}}</option>`
                @endforeach
                
                res += `</select></td><td>`
                res += `<select name="levels[${index}]" class="form-control select" data-container-css-class="bg-orange-400">`
                res += `<option value="0">Select a Level...</option>`

                @foreach ($all_levels as $l)
                res += `<option value="{{$l->id}}">{{$l->name}}</option>`
                @endforeach

                res += `</select></td><td class="text-center">`
                res += `<button type="button" class="btn btn-danger delete_crew" onclick="remove(${index})"><i class="icon-trash"></i> Remove</button>`
                res += `</td></tr>`

                $('tbody').append(res)
            })
        })

        function remove(index) {
            $('#crew_'+index).remove()
        }
    </script>

@endsection
