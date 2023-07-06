@extends('admin.layout.base')

@section('title', 'Parking ')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h4 class="mb-1">
                    Parking
                </h4>
                <!--div class="row">
                    <form action="{{ route('admin.zoneImport') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-4">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Import</button>
                            <a class="btn btn-info" href="{{ route('admin.zoneExport') }}">Download</a>
                        </div>
                    </form>
                </div-->
                <br/>
                <a href="{{ route('admin.parking.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Parking</a>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>Min</th>
                        <th>Med</th>
                        <th>Max</th>
                        <th>Ramp</th>
                        
                        <th>@lang('admin.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parking as $index => $parking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $parking->time }}</td>
                            <td>{{ $parking->time_med }}</td>
                            <td>{{ $parking->time_max }}</td>
                            <td>{{ $parking->ramp }}</td>
                            
                           
                            <td>
                                <form action="{{ route('admin.parking.destroy', $parking->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.parking.edit', $parking->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                    <th>@lang('admin.id')</th>
                        <th>Min</th>
                        <th>Med</th>
                        <th>Max</th>
                        <th>Ramp</th>
                        
                        <th>@lang('admin.action')</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
