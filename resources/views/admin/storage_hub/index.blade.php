@extends('admin.layout.base')

@section('title', 'Storage Hub ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <h5 class="mb-1">
                Storage Hub
            </h5>
            <a href="{{ route('admin.storage_hub.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Storage Hub</a>
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>Per Day Price</th>
                        <th>Per Week Price</th>
                        <th>Per Month Price</th>
                        <th>Per Year Price</th>
                        <th>Price Logic</th>
                        <th>Total Sq Feet</th>
                        <th>Per Sq Feet</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($storageHubs as $index => $storageHub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $storageHub->name }}</td>
                        <td>{{ $storageHub->day }}</td>
                        <td>{{ $storageHub->week }}</td>
                        <td>{{ $storageHub->month }}</td>
                        <td>{{ $storageHub->year }}</td>
                        <td>{{ ($storageHub->time) ? 'Time' : 'Sq Feet' }}</td>
                        <td>{{ $storageHub->total_sq_feet }}</td>
                        <td>{{ $storageHub->sq_feet }}</td>
                        <td>
                            <form action="{{ route('admin.storage_hub.destroy', $storageHub->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.storage_hub.edit', $storageHub->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
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
                        <th>Per Day Price</th>
                        <th>Per Week Price</th>
                        <th>Per Month Price</th>
                        <th>Per Year Price</th>
                        <th>Price Logic</th>
                        <th>Total Sq Feet</th>
                        <th>Per Sq Feet</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
