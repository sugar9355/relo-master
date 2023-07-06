<div class="modal-content  modal-lg">

	  <div class="modal-header">
		<h4 class="modal-title">Referal Details</h4>
	  </div>
	  
	  <div class="modal-body">
	  @isset($referal[0])
			
			
			@foreach($referal as $refer)
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>First Name</label>
						<input class="form-control" type="text" value="{{$refer->first_name}}" name="first_name" required id="first_name" placeholder="first_name">
						
					</div>

					<div class="form-group">
						<label>Last Name</label>
						<input class="form-control" type="text" value="{{$refer->last_name}}" name="last_name" required id="last_name" placeholder="last_name">
					</div>

					<div class="form-group">
						<label>Email</label>
						<input class="form-control" type="text" value="{{$refer->email}}" name="email" required id="email" placeholder="email">
						
					</div>
					
					<div class="form-group">
						<label>Mobile</label>
						<input class="form-control" type="text" value="{{$refer->mobile}}" name="mobile" required id="mobile" placeholder="mobile">
					</div>
					
				</div>
				<div class="col-md-6">
				
					<div class="form-group">
						<label>Token</label>
						<input class="form-control" type="text" value="{{$refer->refer_token}}" name="refer_token" required id="refer_token" placeholder="refer_token">
					</div>
					
					<div class="form-group">
						<label>Device Id</label>
						@if($refer->device_id == '')
								<font color="red">User Not Verified Yet</font>
							@else
								<input class="form-control" type="text" value="{{$refer->device_id}}" name="device_id" required id="device_id" placeholder="device_id">
							@endif
					</div>
					
				</div>
			</div>	
		
			
			@endforeach
				@else
			
				<font color="red"><i>Employee <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> has not Refered anyone yet</i></font>
		
	@endisset
</div>
</div>



						
					<div class="col-md-2">
						<div class="form-group">
							
						</div>	
						<div class="form-group">
							
						</div>	
						<div class="form-group">
							
						</div>	
						<div class="form-group">
							
						</div>	
						<div class="form-group">
							
						</div>	
						<div class="form-group">
							
						</div>	
					</div>	
						
					
					
					

				</div>

</div>
</div>
