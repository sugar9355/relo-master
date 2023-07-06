@extends('admin.layout.base')

@section('title', 'Items Category')

@section('content')
    <div class="card">
	
		<div class="card-header bg-white header-elements-sm-inline">
			<h6 class="card-title"> Manage Item Category</h6>
			<div class="header-elements">
				<a type="button" href="{{ route('admin.category.create') }}"  class="btn btn-dark text-white">Add New Category</a>
			</div>
		</div>
		
        <div class="card-body">
			<table class="table table-striped table-bordered dataTable" id="table-2">
				<thead>
				<tr>
					<th>@lang('admin.id')</th>
					<th>@lang('admin.category_name')</th>
					<th width="20%" class="text-center">@lang('admin.action')</th>
				</tr>
				</thead>
				<tbody>
				@foreach($categories as $index => $category)
					<tr>
						<td>{{ $index + 1 }}</td>
						<td>{{ $category->name }}</td>
						<!--td>{{ $category->time }}</td>
						<td>{{ $category->item_ids }}</td-->
						<td>
							<form action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="DELETE">
								<a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
								<button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
    </div>
@endsection
