<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/demo_pages/datatables_api.js')}}"></script>
	<!-- /theme JS files -->

<!-- Individual column searching (text inputs) -->
<!-- Touchspin spinner -->

<div class="card">
<div class="card-header">
<div class="header-elements mb-2">
	<form action="/admin/dashboard" method="post" enctype="multipart/form-data" class="w-100">
	{{ csrf_field() }}
		<div class="input-group bootstrap-touchspin">
		
		<span class="input-group-prepend bootstrap-touchspin-prefix d-none"><span class="input-group-text"></span></span>
			<input  placeholder=" Customer / Truck / Date / Time" name="search" type="text" value="" class="form-control form-control-touchspin" style="display: block;">
		<span class="input-group-append">
		<button name="btn_search" class="btn btn-light bootstrap-touchspin-up" type="submit"><i class="icon icon-search4"></i></button></span>
		
		<span class="input-group-append">
		<button name="btn_reset" class="btn btn-light bootstrap-touchspin-up" type="submit"><i class="icon icon-reset"></i></button></span>
		</div>
	</form>
</div>
</div>
<div class="col-md-12">


<table class="table table-bordered ">

<thead>
	<tr class="bg-info-700">
		<th width="15%"><i class="icon icon-clipboard5"></i> Booking </th>
		<th width="15%"><i class="icon icon-alarm"></i> Start Time</th>
		<th width="15%"><i class="icon icon-reading"></i> Customer</th>
		<th width="15%"><i class="icon icon-calendar"></i> Primary date</th>
		<th width="15%"><i class="icon icon-truck"></i> Truck</th>
		<th width="15%"><i class="icon icon-reading"></i> Captain</th>
		<th width="5%"class="text-center">Actions</th>
	</tr>
</thead>
<tbody>

@foreach($jobs as $job) 


<tr>
<td>{{$job->booking_id}}</td>
<td>{{$job->start_time}}</td>
<td><a href="/admin/user_request/{{$job->booking_id}}">{{$job->first_name}} {{$job->last_name}}</a></td>
<td>{{$job->primary_date}}</td>
<td class="text-center">
	@if($job->truck_id)
	@foreach($trucks as $truck)
		@if($truck->id == $job->truck_id)
			<span class="badge badge-success">{{$truck->name}}</span>
		@endif
	@endforeach
	@else
		<span class="badge badge-danger">---</span>
	@endif
</td>
<td>{{$job->customer}}</td>
<td class="text-center">
			<div class="list-icons">
				<div class="dropdown">
					<a href="#" class="list-icons-item" data-toggle="dropdown">
						<i class="icon-menu9"></i>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-eye text-info"></i> view</a>
						<a href="#" class="dropdown-item"><i class="icon-bin2 text-danger"></i> delete</a>
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
<!-- /individual column searching (text inputs) -->	


