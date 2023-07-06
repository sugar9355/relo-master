@extends('admin.layout.base')

@section('title', 'Roles ')

@section('content')
<div class="card">

	<div class="card-header bg-white header-elements-sm-inline">
		<h6 class="card-title"> Roles</h6>
		<div class="header-elements">
			<a type="button" href="{{ route('admin.role.create') }}"  class="btn btn-dark text-white">Add New Role</a>
		</div>
	</div>
	
    <div class="card-body">

            <table class="table table-striped table-bordered dataTable">
                <thead class="bg-dark">
                    <tr>
                        <th class="text-center">@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>Label</th>
						<th class="text-center">Hourl Rate</th>
                        <th class="text-center">@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->label }}</td>
						<td class="text-center">{{ $role->hourly_rate }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection
