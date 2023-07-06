@extends('user.layout.app')

@section("styles")
<!-- <link rel="stylesheet" href="{{asset('css/inventory_slide.css')}}"> -->
@endsection

@section('content')
<style>
	.list-group .list-group-item:before{
		background-color: var(--dark);
	}
	.animated {
    -webkit-animation-fill-mode: inherit;
    animation-fill-mode: inherit;
}
</style>

 <div class="container my-5"> 

@if($errors->any())
		<div class="card">
		<div class="card-body">
			{!! implode('', $errors->all('<div>:message</div>')) !!}
		</div>
		</div>
@endif


<div class="row">

	<div class="col-md-3 pr-0">	

		<div class="card card-body p-0 bg-dark h-100">
			<h5 class="m-3">Select Category</h5>
			<div class="list-group">
			
				
				@if(isset($presets[0]))
					<form action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						@foreach($presets as $preset)
						@php
						$item_ids = 0;
						$item_ids = explode(',',$preset->item_ids); @endphp
						
						<button type="submit" name="btn_preset" value="{{$preset->item_ids}}" class="list-group-item list-group-item-action hvr-grow list-group-item-action bg-transparent text-white">						
							<i class="fas fa-couch mr-2"></i>
							{{$preset->name}}
							<span class="badge bg-info float-right">{{ count($item_ids) }}</span>
						</button>
						
						@endforeach
					</form>
				@endif

			</div>
			
		</div>
		
	</div>

	<div class="col-md-9">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Add Inventory Items</h6>

				<div class="row">
					<div class="col-md-10">
						<form action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data" class="m-0">
						{{ csrf_field() }}
							<div class="input-group w-100">
								<input name="item_search" type="text" class="form-control" value="@if(isset($search)){{$search}}@endif" placeholder="Search...">
								<div class="input-group-append">
									<button type="submit" name="btn_search" value="true"  class="btn btn-dark"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col text-right">
						<button class="btn bg-warning btn-block" data-toggle="modal" data-target="#create_item"><i class="fas fa-plus"></i> Create</button>
						@include('booking.includes.create_item')
					</div>
				</div>				
				
			</div>
			
			<div class="card-body">
			
				<!-- Grid -->
					<div class="row">
				@foreach($items as $item)		
					
						<div class="col-xl-2 col-sm-3">
							<div class="card card-body bg-light text-center p-2 mb-3">
								@if($item->file_path == '')
								<a href="/no_item.jpg" data-popup="lightbox">
										<img src="/no_item.jpg" class="card-img" height="60" alt="">
										<!-- <span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span> -->
									</a>
								@else
								@if($item->ranking_id == null && $item->question == false)
								<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
									{{csrf_field()}}

									<input type="hidden" name="item_id" value="{{ $item->id }}">
									<input type="hidden" name="item_name" value="{{ $item->name }}">
									
									@if(!empty($booking_location))
										@foreach($booking_location as $k => $loc)
											@if($k == 0)
											<input type="hidden" name="pick_up_loc_id" value="{{$loc->booking_loc_id}}">
											@elseif($k == (count($booking_location) - 1))
											<input type="hidden" name="drop_off_loc_id" value="{{$loc->booking_loc_id}}">
											@endif
										@endforeach
									@endif
									
									<button type="submit" name="btn_submit" value="5">
										<img src="{{$item->file_path}}" class="card-img" height="60" alt="">
										<!-- <span class="card-img-actions-overlay card-img"><i class="icon-plus3"></i></span> -->
									</button>
									
								</form>
								@else
									<a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
										<img src="{{$item->file_path}}" class="card-img" height="60" alt="">
										<!-- <span class="card-img-actions-overlay card-img"><i class="icon-plus3"></i></span> -->
									</a>
								@endif
								@endif	

								<small class="pt-2">{{ ucfirst($item->name) }}</small>
							</div>
						</div>
						
						@include('booking.includes.ranking_add')
					
				@endforeach
				</div>
			</div>			
		</div>
	</div>

</div>


@if($selected_items) 

	
	
@endif

@php $limit_execeed = false; @endphp


<div class="row">
	<div class="col-md-12 mt-4">
	
		@foreach($booking_form_truck as $truck)
		
		<div class="row">
			<div class="col-md-3 pr-0">
				<div class="card bg-transparent">
				
				@php $items_volume = 0; @endphp
				
				@foreach($selected_items as $added_item) 
				@if($added_item->truck_id == $truck->truck_id)
				
				@if($added_item->quantity > 0)
					@php $items_volume = $items_volume + ($added_item->volume * $added_item->quantity); @endphp 
				@else
					@php $items_volume = $items_volume + $added_item->volume; @endphp 
				@endif
					
				@endif
				@endforeach 				
				
				@if($truck->status == 1 && round(($items_volume/$truck->truck_volume)* 100) > 80)
					@php $limit_execeed = true; @endphp
				@endif
					
					<div class="card-header">
						<h6 class="m-0" data-toggle="modal" data-target="#truck_{{$truck->id}}">Truck Capacity	{{$truck->volume}} {{$truck->truck_volume}} - {{$items_volume}}</h6>
						
						<!-- Modal -->
						<div id="truck_{{$truck->id}}" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title">Modal Header</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							  </div>
							  <div class="modal-body">
							  <table class="table table-striped">
							  
							  <tr><td>Name </td><td> {{$truck->name}}</td></tr>
							  <tr><td>Type </td><td> {{$truck->type}}</td></tr>
							  <tr><td>color </td><td> {{$truck->color}}</td></tr> 
							  <tr><td>fuel_volume </td><td> {{$truck->fuel_volume}}</td></tr>
							  <tr><td>year </td><td> {{$truck->year}}</td></tr>
							  <tr><td>reg_no </td><td> {{$truck->reg_no}}</td></tr>
							  <tr><td>fuel_type </td><td> {{$truck->fuel_type}}</td></tr>
							  <tr><td>weight </td><td> {{$truck->weight}}</td></tr>
							  <tr><td>height </td><td> {{$truck->height}}</td></tr> 
							  <tr><td>breadth </td><td> {{$truck->breadth}}</td></tr> 
							  <tr><td>volume </td><td> {{$truck->volume}}</td></tr> 
							  <tr><td>mileage </td><td> {{$truck->mileage}}</td></tr> 
							  <tr><td>threshold </td><td> {{$truck->threshold}}</td> </tr> 
							  
								</table>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>
						
					</div>
					<div class="card-body pt-3 border-top mx-1" style="height:145px;background-image: url('/truck.jpg');background-repeat: no-repeat; background-position: center; background-size: contain;">
						<div class="row">
							<div class="col-md-10 pt-2 mt-1 pl-2">								
								<div class="progress h-100">
								  <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark py-3" style="width:{{round(($items_volume/$truck->truck_volume)* 100)}}%;" role="progressbar" aria-valuenow="{{round(($items_volume/$truck->truck_volume)* 100)}}" aria-valuemin="0" aria-valuemax="100">{{round(($items_volume/$truck->truck_volume)* 100)}}%</div>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
				
								
				
			</div>
			<div class="col-md-9">
				<div class="card">
					<div class="card-header form-inline">
						
						@if($limit_execeed == true)
						<h6 class="card-title m-0 col-md-4">Selected Items </h6>
						
						<div class="col-md-4 text-center">
							<font color="red">Truck Limit Exceeded </font>
						</div>
						
						<div class="col-md-4 text-right">
							<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newtruck">Get New Truck</button>
							@include('booking.includes.truck_change')		
						</div>
						@else
						<h6 class="card-title m-0 col-md-10">Selected Items</h6>
						@endif
						
						
					</div>
					<div class="card card-body">
					
						@include('booking.includes.selected_items')
					
					</div>
				</div>
			</div>			
		</div>
		
		@endforeach
		
	</div>
	
	@include('booking.includes.accuracy')
	
	<div class="col-md-12 text-center">
        <hr>
		<a href="/booking/{{ ($booking->booking_id) ?: null }}/4" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
		<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_next" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue  <i class="fas fa-chevron-right hvr-icon"></i></a>
				
	</div>

	</div>
	
</div>
@endsection

<script src="{{asset('asset/js/inventory_slide.js')}}"></script>
<script src="{{asset('asset/booking/inventory.js')}}"></script>
