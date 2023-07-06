<h5 class="pb-2 mb-3 border-bottom">Equipment Required to Move item</h5>

<div class="form-row">
			@if(isset($equipments))
				<?php $inv_equip = explode(',',$inventory->equipments); ?>
				@foreach($equipments as $k => $e)

	<div class="col form-group">

		<div class="custom-control custom-checkbox">
		  <input type="checkbox" class="custom-control-input">
			<input class="custom-control-input" type="checkbox" name="equipment[]" id="{{$e->equipment_name}}" @if(in_array($e->equipment_id,$inv_equip)) checked @endif value="{{$e->equipment_id}}"> 
		  <label class="custom-control-label" for="{{$e->equipment_name}}">{{$k+1}}) {{$e->equipment_name}}</label>
		</div>
	</div>
				@endforeach
			@endif
</div>

<hr>
