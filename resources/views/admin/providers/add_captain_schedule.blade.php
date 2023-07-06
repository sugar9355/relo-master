<div class="card card-body">

	<h4 class="m-0">Update Banking Details</h4>
	  
	<hr>
	  
<form action="{{route('admin.provider.store')}}" method="POST" enctype="multipart/form-data" role="form">
{{csrf_field()}}


<p class="lead"><strong>Captain Schedule</strong></p>

<div class="form-group">

		<label for="Monday" class="form-label">Select Hours (Start Time - End Time)</label>	

		<div class="row">
			<div class="col-md-3">
			<select class="form-control" name="hours" required id="hours" placeholder="hours">
				
				<option value="1:00">1:00</option>
				<option value="2:00">2:00</option>
				<option value="3:00">3:00</option>
				<option value="4:00">4:00</option>
				<option value="5:00">5:00</option>
				<option value="6:00">6:00</option>
				<option value="7:00">7:00</option>
				<option value="8:00">8:00</option>
				<option value="9:00">9:00</option>
				<option value="10:00">10:00</option>
				<option value="11:00">11:00</option>
				<option value="12:00">12:00</option>
				
			</select>
			</div>

			<div class="col-md-3">
				<select class="form-control" name="unit" required id="unit" placeholder="unit">
			
					<option value="AM">AM</option>
					<option value="PM">PM</option>
					
				</select>

			</div>
			<div class="col-md-3">
				<select class="form-control" name="end_hours" required id="end_hours" placeholder="hours">
					
					<option value="1:00">1:00</option>
					<option value="2:00">2:00</option>
					<option value="3:00">3:00</option>
					<option value="4:00">4:00</option>
					<option value="5:00">5:00</option>
					<option value="6:00">6:00</option>
					<option value="7:00">7:00</option>
					<option value="8:00">8:00</option>
					<option value="9:00">9:00</option>
					<option value="10:00">10:00</option>
					<option value="11:00">11:00</option>
					<option value="12:00">12:00</option>
					
				</select>
				</div>
	
				<div class="col-md-3">
					<select class="form-control" name="end_unit" required id="end_unit" placeholder="unit">
				
						<option value="AM">AM</option>
						<option value="PM">PM</option>
						
					</select>
	
				</div>
			</div>

<div class="form-group">

<div class="row text-center mt-3">
		<div class="col">
			<label for="Monday">Monday</label>
			<input class="form-control" type="checkbox" value="1" name="monday"  id="monday" placeholder="Monday">
		</div>
		<div class="col">
			<label for="Monday">Tuesday</label>
			<input class="form-control" type="checkbox" value="1" name="tuesday"  id="tuesday" placeholder="Tuesday">
		</div>
		<div class="col">
			<label for="Monday">Wednesday</label>
			<input class="form-control" type="checkbox" value="1" name="wednesday"  id="wednesday" placeholder="Tuesday">
		</div>
		<div class="col">
			<label for="Monday">Thursday</label>
			<input class="form-control" type="checkbox" value="1" name="thursday"  id="thursday" placeholder="Thursday">
		</div>
		<div class="col">
			<label for="Monday">Friday</label>
			<input class="form-control" type="checkbox" value="1" name="friday"  id="friday" placeholder="Friday">
		</div>
</div>
</div>

<hr>

		<button type="submit" class="btn btn-outline-dark">Cancel</button>
		<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>

	
</form>

</div>
