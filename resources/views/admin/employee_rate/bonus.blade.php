



<div class="form-group">
<div class="col-md-10"><hr></div>
<label for="mobile" class="col-md-12 col-form-label">Bouns</label>


<div class="col-md-10"><hr></div>
</div>

<div class="form-group">

@foreach($ref_hours_arr as $hour)
<div class="col-md-12 mb-1">
	<div class="col-md-2"><label for="Monday" class="col-form-label">Refer User Name</label></div>	
	<div class="col-md-2">{{$hour['refer_user']}}</div>	
</div>
<div class="col-md-12 mb-1">
	<div class="col-md-2"><label for="Monday" class="col-form-label">Refer User Minutes</label></div>	
	<div class="col-md-2">{{$hour['minutes']}} mins</div>	
</div>
@endforeach

</div>