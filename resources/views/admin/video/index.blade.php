@extends('admin.layout.base')

@section('title', 'Videos ')

@section('content')

<!-- Highlighting rows and columns -->
	<div class="card">
<div class="card-header bg-white header-elements-sm-inline">
	<h6 class="card-title"> Videos</h6>
	<div class="header-elements">
		<a type="button" href="{{ route('admin.video.create') }}"  class="btn btn-dark text-white">Add New Video</a>
	</div>
</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
				 <tr>
					<th>@lang('admin.id')</th>
					<th>Video Name</th>
					<th>Video</th>
					<th width="10%" class="text-center">@lang('admin.action')</th> 	
				</tr>
			</thead>
			 <tbody>
                    @foreach($videos as $index => $video)
                    <tr>
                        <td>{{ $index + 1 }}</td>
						<td>{{ $video->video_name }}</td>
                        <td>{{ $video->file }}</td>
						<td>						
						<div class="btn-group ml-2">
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<button type="button" class="dropdown-item" data-toggle="modal" data-target="#view_{{$video->id}}"><i class="icon-eye text-teal"></i> view</button>
								<a href="{{ route('admin.video.edit', $video->id) }}" class="dropdown-item"><i class="icon-pencil text-primary"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $video->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</div>
						
						<!-- Trigger the modal with a button -->
						

						<!-- Modal -->
						@include('admin.video.includes.modal_view')
							
							<!-- Modal -->
							<div id="delete_{{ $video->id }}" class="modal fade" role="dialog">
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
								
									 <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST">
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
