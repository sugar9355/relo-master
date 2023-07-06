
<div class="form-group row">
	<div class="col-xs-10"><hr></div>
	<label for="mobile" class="col-xs-12 col-form-label">Badges</label>


	<div class="col-xs-10"><hr></div>
</div>

<div class="form-group row">
	<div class="col-xs-12 mb-1">
		<div class="col-xs-2">
			<label for="Monday" class="col-form-label">Name:</label>
		</div>
		
		<div class="col-xs-2">
			@if(isset($badges->name)) {{$badges->name}} @endif
		</div>
		
		<div class="col-xs-2">
			
		</div>
		
	</div>

</div>
