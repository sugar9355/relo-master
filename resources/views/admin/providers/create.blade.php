@extends('admin.layout.base')

@section('title', 'Add Provider ')

@section('content')

<!-- Vertical tabs -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			
			<div class="card-header bg-white header-elements-sm-inline">
				<h3 class="m-0">Employee</h3>
				<div class="header-elements">
					<button type="button" class="btn alpha-primary border-primary text-primary-800 btn-icon ml-2" data-toggle="modal" data-target="#bonus"><i class="icon-coins"></i></button>
					<button type="button" class="btn alpha-primary border-primary text-primary-800 btn-icon ml-2" data-toggle="modal" data-target="#badges"><i class="icon-medal-star"></i></button>
				</div>
			</div>
			
			<div class="card-body">
				<div class="d-md-flex">
					<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0">
						<li class="nav-item"><a href="#vertical-left-tab1" class="nav-link active" data-toggle="tab"><i class="icon-user text-info mr-2"></i> Employee Details</a></li>
						{{-- <li class="nav-item"><a href="#vertical-left-tab2" class="nav-link" data-toggle="tab"><i class="icon-cash text-primary mr-2"></i> Banking Details</a></li> --}}
					</ul>

					<div class="tab-content w-100">
					
						<div class="tab-pane fade show active" id="vertical-left-tab1">
							@include('admin.providers.add_employee')
						</div>

						{{-- <div class="tab-pane fade" id="vertical-left-tab2">
							@include('admin.providers.add_captain_schedule')
						</div> --}}

					</div>
				</div>
			</div>
		</div>
	</div>


</div>
<!-- /vertical tabs -->

@endsection
