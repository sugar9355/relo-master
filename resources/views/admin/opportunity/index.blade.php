@extends('admin.layout.base')

@section('title', 'Opportunity')

@section('content')
<div class="card">
	<div class="card-header bg-white header-elements-sm-inline">
	<h6 class="card-title"> Job Opportunity</h6>
	<div class="header-elements">
		<a type="button" href="{{ route('admin.opportunity.create') }}"  class="btn btn-dark text-white">Add New Opportunity</a>
	</div>
</div>
    <div class="card-body">
			
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr class="bg-dark text-white">
					<th>Name</th>
					<th>Designation</th>
					<th>Hourly Rate</th>
					<th>Validaity</th>
					<th>Created_at</th>
					<th>Description</th>
					<th>@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Opportunitys as $index => $Opportunity)
                    <tr>
                        
                        <td>{{ $Opportunity->name }}</td>
						<td>{{ $Opportunity->role }}</td>
						<td>{{ $Opportunity->hourly_rate }}</td>
                        <td class="text-center">{{ $Opportunity->validaity }}</td>
                        
						<td>{{ $Opportunity->created_at }}</td>
						<td>
						
						<!-- Trigger the modal with a button -->
						<button type="button" class="btn alpha-primary border-primary text-primary-800 btn-icon ml-2" data-toggle="modal" data-target="#des_{{ $Opportunity->id }}"><i class="icon-clipboard3"></i></button>

						<!-- Modal -->
						<div id="des_{{ $Opportunity->id }}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title">Description</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							  </div>
							  <div class="modal-body">
								<p>{{ $Opportunity->description }}</p>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>
						
						
						</td>
                  
						<td>						
						<div class="btn-group ml-2">
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<a href="{{ route('admin.opportunity.edit', $Opportunity->id) }}" class="dropdown-item"><i class="icon-pencil text-primary"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $Opportunity->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</div>
							
							<!-- Modal -->
							<div id="delete_{{ $Opportunity->id }}" class="modal fade" role="dialog">
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
									 <form action="{{ route('admin.opportunity.destroy', $Opportunity->id) }}" method="POST">
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
</div>
@endsection
