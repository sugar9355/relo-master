@extends('admin.layout.base')

@section('title', 'Zone Type ')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h4 class="mb-1">
                    @lang('admin.vehicle.Zone_Type')
                </h4>
                <div class="row">
                    <form action="{{ route('admin.zoneImport') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{-- <div class="col-md-4">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Import</button>
                            <a class="btn btn-info" href="{{ route('admin.zoneExport') }}">Download</a>
                        </div> --}}
                    </form>
                </div>
                <br/>
                <a href="{{ route('admin.zone_type.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Zone Type</a>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.zip_code')</th>
                        <th>Zone @lang('admin.color')</th>
                        <th>@lang('admin.flag')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zoneTypes as $index => $zoneType)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $zoneType->name }}</td>
                            <td>{{ $zoneType->zip_code }}</td>
                            <td style="background-color: {{ $zoneType->color }}">{{ $zoneType->color }}</td>
                            @if (isset($zoneType->flag))
                            <td style="color: {{$flags[$zoneType->flag]}}"><i class="icon-flag7"></i></td>
                            @else
                            <td></td>
                            @endif
                            <td>
                                <form action="{{ route('admin.zone_type.destroy', $zoneType->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.zone_type.edit', $zoneType->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.zip_code')</th>
                        <th>@lang('admin.color')</th>
                        <th>@lang('admin.flag')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
