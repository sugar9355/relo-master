@extends('user.layout.app')

@section("styles")
<link rel="stylesheet" href="{{asset('css/inventory_slide.css')}}">
@endsection

@section('content')
	<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/colors.min.css')}}" rel="stylesheet" type="text/css">

<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/ui/prism.min.js')}}"></script>

<style>
	.list-group .list-group-item:before{
		background-color: var(--dark);
	}
	.animated {
    -webkit-animation-fill-mode: inherit;
    animation-fill-mode: inherit;
}
</style>

<div class="container"> 

@if($errors->any())
		<div class="card">
		<div class="card-body">
			{!! implode('', $errors->all('<div>:message</div>')) !!}
		</div>
		</div>
@endif


<div class="row">

<div class="col-md-3">
								
<div class="sidebar sidebar-dark sidebar-component position-static w-100 h-100 d-block mb-md-4">
	<div class="sidebar-content position-static">

		<!-- Navigation -->
		<div class="card">
			<ul class="nav nav-sidebar" data-nav-type="accordion">
				<li class="nav-item-header">
					<div class="text-uppercase font-size-sm line-height-sm">Select Category </div>
				</li>
				
				@if(isset($presets[0]))
					<form action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						@foreach($presets as $preset)
						@php
						$item_ids = 0;
						$item_ids = explode(',',$preset->item_ids); @endphp
						<li class="nav-item">
							<a href="{{$preset->item_ids}}" class="nav-link">
							
							
								<i class="icon-furniture"></i>
								{{$preset->name}}
								<span class="badge bg-teal-800 ml-auto">{{ count($item_ids) }}</span>
							</a>
						</li>
						@endforeach
					</form>
				@endif


			</ul>
		</div>
		<!-- /navigation -->

	</div>
</div>
</div>
	<div class="col-md-9">
		<div class="card border-teal-400 mb-0">
			<div class="card-header bg-teal-400 text-white header-elements-inline pb-0 pt-0">
				<h6 class="card-title">Add Inventory Items</h6>
				
				<form class="col-md-6 mb-0" action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="input-group wmin-sm-200 m-1">
						<input type="text" class="form-control" placeholder="Search...">
						<div class="input-group-append">
							<button type="submit" name="btn_search" value="true"  class="btn btn-light btn-icon"><i class="icon-search4"></i></button>
						</div>
					</div>
				</form>
				
				<div class="header-elements">
				
					<div class="btn-group">
						<button class="btn bg-warning" data-toggle="modal" data-target="#create_item"><i class="icon-plus3"></i> Create</button>
						
					</div>
					@include('booking.includes.create_item')
				</div>
			</div>
			
			<div class="card-body">
			
				<!-- Grid -->
					<div class="row">
				@foreach($items as $item)		
					
						<div class="col-xl-2 col-sm-3">
							<div class="card">
							
						
								<div class="card-body">
									<div class="card-img-actions">
									
									@if($item->file_path == '')
									<a href="/no_item.jpg" data-popup="lightbox">
											<img src="/no_item.jpg" class="card-img" width="80" height="60" alt="">
											<span class="card-img-actions-overlay card-img">
												<i class="icon-zoomin3"></i>
											</span>
										</a>
									@else
										<a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
											<img src="{{$item->file_path}}" class="card-img" width="80" height="60" alt="">
											<span class="card-img-actions-overlay card-img">
												<i class="icon-plus3"></i>
											</span>
										</a>
									@endif	
									</div>
								</div>
								

								<div class="card-body bg-light text-center pt-1 pb-0">
									<div class="mb-2">
										
											<font size="1">{{ ucfirst($item->name) }}</font>
										
									</div>

								</div>
							</div>
						</div>
						
						@include('booking.includes.item_add')
					
				@endforeach
				</div>
			</div>			
		</div>
		
		@include('booking.includes.truck3')
				
		<div class="card mt-1 mb-0">
			<div class="card-footer bg-white d-flex justify-content-between align-items-center">
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/4" name="btn_save_step_back" class="btn btn-outline bg-indigo-400 text-indigo-400 border-indigo-400"><i class="icon-arrow-left52"></i> Back</a>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" class="btn bg-blue">Continue <i class="icon-arrow-right6"></i></a>
			</div>
		</div>
		
	</div>
	


	</div>

@endsection

<script src="{{asset('asset/js/inventory_slide.js')}}"></script>
