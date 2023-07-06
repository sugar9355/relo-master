@extends('admin.layout.base')

@section('title', 'Backend Users ')

@section('content')
<!-- Highlighting rows and columns -->
	<div class="card">
<div class="card-header bg-white header-elements-sm-inline">
	<h3 class="m-0"> Backend Users</h3>
	<div class="header-elements">
		<a type="button" href="{{ route('admin.system_user.create') }}"  class="btn btn-dark text-white"><i class="fa fa-plus"></i> Add New Backend User</a>
	</div>
</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
				<tr class="bg-dark text-white">
					  <th>@lang('admin.id')</th>
                        <th>@lang('admin.first_name')</th>
                        <th>@lang('admin.last_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.mobile')</th>
                        <th class="text-center">@lang('admin.action')</th>
				</tr>
			</thead>
			 <tbody>
                      @foreach($systemUsers as $index => $systemUser)
					<tr>
						 <td>{{ $index + 1 }}</td>
                        <td>{{ $systemUser->first_name }}</td>
                        <td>{{ $systemUser->last_name }}</td>
                        <td>{{ $systemUser->email }}</td>
                        <td>{{ $systemUser->mobile }}</td>
						
						<td class="text-center">
						<div class="btn-group ml-2">
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<a href="{{ Route('admin.system_user.edit', $systemUser->id) }}" class="dropdown-item"><i class="icon-pencil"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $systemUser->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</div>

							<!-- Modal -->
							<div id="delete_{{ $systemUser->id }}" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header text-center">
									<h4 class="modal-title">Are You Sure ?</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								  </div>
								  <div class="modal-body  text-center">
									<hr>
										Do you want to delete Selected Row ?
									<hr>
								  </div>
								  <div class="modal-footer">
									 <form action="{{ route('admin.system_user.destroy', $systemUser->id) }}" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-success" >Yes</button>
									</form>
									<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
								  </div>
								</div>

							  </div>
							</div>
						</td>
					</tr>
                    @endforeach
                    </tbody>
		
		</table>
	</div>
	
	<div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center"></div>
	</div>
	<!-- /highlighting rows and columns -->

@endsection
