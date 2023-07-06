



<div class="form-group row">
<div class="col-xs-10"><hr></div>
<label for="mobile" class="col-xs-12 col-form-label">Bouns</label>


<div class="col-xs-10"><hr></div>
</div>

<div class="form-group row">

@foreach($ref_hours_arr as $hour)
<div class="col-xs-12 mb-1">
	<div class="col-xs-2"><label for="Monday" class="col-form-label">Refer User Name</label></div>	
	<div class="col-xs-2">{{$hour['refer_user']}}</div>	
</div>
<div class="col-xs-12 mb-1">
	<div class="col-xs-2"><label for="Monday" class="col-form-label">Refer User Minutes</label></div>	
	<div class="col-xs-2">{{$hour['minutes']}} mins</div>	
</div>
@endforeach

</div>