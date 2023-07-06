@extends('admin.layout.base')

@section('title', 'Difficulty Levels')

@section('content')
	<!-- Accordion with right control button -->
	 
	<div class="card-group-control card-group-control-right" id="accordion">
		<div class="card border-dark">
			<div class="card-header bg-dark">
				<h6 class="card-title">
					<a data-toggle="collapse" class="text-white" href="#accordion-control">Difficulty Levels</a>
				</h6>
			</div>

			<div id="accordion-control" class="collapse show" data-parent="#accordion">
				<div class="card-body">
					<div class="row">
					@foreach($dlevels as $index => $dlevel)
					<div class="col-lg-12">
						<div class="card border-left-3 rounded-left-0">
							<div class="card-body">
								<div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
									<div>
										<div class="form-inline mb-3">
											<span class="badge badge-flat border-primary text-primary-600 badge-icon mb-2 mr-2"><i class="icon-stack2 icon-2x"></i></span>
											<h4 class="font-weight-semibold">{{ $dlevel->dlevel }}</h4>
										</div>
										
										
										<h6 class="font-weight-semibold">@lang('admin.item_ids')</h6>
										<div class="form-inline">
											
											@php $items = explode(',',$dlevel->items); @endphp
											@foreach($items as $item)
											<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-furniture"></i> {{ $item }}</span>
											@endforeach
											
										</div>
										
										<h6 class="font-weight-semibold">Crew</h6>
										
											@if(isset($crew[0]))
												@foreach($crew as $ck => $c)
												
													@if($dlevel->id == $c->dlevel_id)
													<div class="form-inline">
														<span class="badge bg-danger mb-2 mr-2 ">{{$ck+1}}</span>
														@if(!empty($c->roles))
															@php $crew_roles = explode(',',$c->roles); @endphp
															@foreach($crew_roles as $role)
																@foreach($roles as $r)
																	@if($role == $r->id)
																		<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-users4"></i> {{$r->name}}</span>
																	@endif
																@endforeach
															@endforeach
														@endif
														</div>
													@endif
													
												@endforeach
											@else
												<span class="badge bg-danger mr-2 ">Not Exist</span>
											@endif
											
										
										
										
										
									</div>

									<div class="text-sm-right mb-0 mt-3 mt-sm-0 ml-auto">
										<ul class="list list-unstyled mb-0">
											<li><span class="font-weight-semibold"> Stairs Type : </span><span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-stairs"></i> {{ $dlevel->stairs_type }}</span></li>
											<li><span class="font-weight-semibold"> Elevator : </span>
											@php $elevators = explode(',',$dlevel->elevator); @endphp
											@foreach($elevators as $elevator)
											<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2">
											@if($elevator == 'cargo')<i class="icon-codepen"></i>@endif
											@if($elevator == 'passanger')<i class="icon-people"></i>@endif
											 {{ $elevator }}</span>
											@endforeach	
											</li>
										</ul>
										
									</div>
								</div>
							</div>

							<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
								<span>
									<span class="badge badge-mark border-danger mr-2"></span>
									Last Updated:
									<span class="font-weight-semibold">{{$dlevel->updated_at}}</span>
								</span>

								<ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
									
									<li class="list-inline-item dropdown">
									
										<a href="{{ Route('admin.AddCrew', $dlevel->id) }}" class="btn mr-3"><i class="icon-users4 text-primary"></i> Add Crew</a>
										<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
										
										<div class="dropdown-menu dropdown-menu-right">
											<a href="{{ Route('admin.dlevel.edit', $dlevel->id) }}" class="dropdown-item"><i class="icon-file-plus text-primary"></i> @lang('admin.edit')</a>
											<button class="dropdown-item"  data-toggle="modal" data-target="#delete_{{ $dlevel->id }}" ><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					
					<!-- Modal -->
					<div id="delete_{{ $dlevel->id }}" class="modal fade" role="dialog">
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
							 <form action="{{ route('admin.dlevel.destroy', $dlevel->id) }}" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="DELETE">
								<button type="submit" name="delete_dlevel" value="true" class="btn btn-success" >Yes</button>
							</form>
							<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
						  </div>
						</div>

					  </div>
					</div>
					@endforeach
							
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- /accordion with right control button -->
@endsection
