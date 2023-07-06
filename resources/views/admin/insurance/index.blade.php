@extends('admin.layout.base')

@section('title', 'Insurance Category ')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h5 class="mb-1">
                    Manage Insurance Category
                </h5>
                <a href="{{ route('admin.insurance.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Insurance Category</a>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.category_name')</th>
                        <th>@lang('admin.ratio')</th>
						<th>Badge Required</th>
                        <th>@lang('admin.action')</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insuranceCategories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->ratio }}</td>
							
							<td>
								@foreach($designations as $badge)
									@if($badge->id == $category->badge_required)
										{{ $badge->name }}
									@endif
								@endforeach
							</td>
							
                            <td>
                                <form action="{{ route('admin.insurance.destroy', $category->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.insurance.edit', $category->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.category_name')</th>
                        <th>@lang('admin.ratio')</th>
						<th>Badge Required</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
