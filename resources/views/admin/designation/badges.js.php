@extends('admin.layout.base')

@section('title', 'Designation')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <h5 class="mb-1">
                Badges
            </h5>
            <a href="{{ route('admin.designation.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add New Badges</a>
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>Bonus</th>
                        <th>Level</th>
                        <th>Hours</th>
                        
                        <th>@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designations as $index => $designation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $designation->name }}</td>
                        <td>{{ $designation->bonus }}</td>
                        <td>{{ $designation->level }}</td>
                        <td>{{ $designation->hours }}</td>
                        
                        <td>
                            <form action="{{ route('admin.designation.destroy', $designation->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.designation.edit', $designation->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
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
                        <th>Bonus</th>
                        <th>Level</th>
                        <th>Hours</th>
                        <th>Consecutive days</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
