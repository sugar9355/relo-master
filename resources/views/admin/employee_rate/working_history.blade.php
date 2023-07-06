<form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
{{csrf_field()}}
<input type="hidden" name="_method" value="PATCH">

<div class="form-group">
<div class="col-md-10"><hr></div>
<label for="mobile" class="col-md-12 col-form-label">Working History</label>


<div class="col-md-10"><hr></div>
</div>

<div class="form-group">

<div class="col-md-12 mb-1">
	<div class="col-md-2">
		<label for="Monday" class="col-form-label">Total Working Hours</label>
	</div>
	
	
	<div class="col-md-2">
		@if(isset($hours)) {{$hours}} hours @endif
	</div>
	
	<div class="col-md-2">
		
	</div>
	
</div>

<div class="col-md-12 mb-1">
	<div class="col-md-2">
		<label for="Monday" class="col-form-label">Total Amount</label>
	</div>
	
	
	<div class="col-md-2">
		@if(isset($total_amount)) {{$total_amount}} {{$employee_amount->unit}} @endif
	</div>
	
	<div class="col-md-2">
		
	</div>
	
</div>
<div class="col-md-12">	
	<div class="col-md-2">
		<label for="Monday" class="col-form-label">Total Working Days</label>
		
	</div>
	
	<div class="col-md-2">
				
		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">View Dates</button>

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Total Working Days</h4>
			  </div>
			  <div class="modal-body">
				<table class="table table-bordered" >
				<thead> <tr><td>Shift Start</td><td>Shift End</td><td>Shift Hours</td></tr></thead>
				 <tbody>
				@foreach($working_hours as $hours)
				
					<tr>
						<td>{{$hours->shift_start}}</td>
						<td>{{$hours->shift_end}}</td>
						<td>{{$hours->hours}}</td>
					</tr>
					
				@endforeach
				 </tbody>
				</table>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
	</div>
	
	<div class="col-md-2">
		
	</div>
	
</div>

</div>

<div class="form-group">

<div class="col-md-12 mb-1">

	<div class="col-md-2">
		<label for="Monday" class="col-form-label">Payment Recieved</label>
	</div>
	
	<div class="col-md-10">
	@if(isset($last_claim) && ($last_claim->payment_recieved == null))
		
		<input type="hidden" name="amount" value="@if(isset($total_amount)) {{$total_amount}} @endif" >
		<button type="submit" name="update_claim" value="true"  class="btn btn-primary">Confirm</button><br>
		
	@else
		<font color="red">User has not Claimed Yet</font>
	@endif
		
	</div>
	
</div>

<div class="col-md-12 mb-1">
	<div class="col-md-10">
		<span class="text-danger">Note: click on confirm button If Payment is Disbursed</span>
	</div>
</div>

</div>


</form>
