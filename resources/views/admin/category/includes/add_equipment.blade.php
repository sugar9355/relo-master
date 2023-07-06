<div class="form-group">
	<div class="col-md-10"><hr></div>
	<label for="mobile" class="col-md-12 col-form-label ml-3">Equipment Required to Move item</label>
	<div class="col-md-10">
		<hr>
	</div>
</div>

<div class="form-group row m_b">

		<div class="col-md-12 ml-2">
			<table>
				@if(isset($equipments))
					@foreach($equipments as $k => $e)
				
						<tr>
							<td width="10%" class="p-1">
								<label for="" class="col-form-label">{{$k+1}}</label>)
							</td>
							<td width="80%" class="p-1">
								<label for="" class="col-form-label">{{$e->equipment_name}}</label>
							</td>
							
							<td>
								<input class="form-control" type="checkbox" name="equipment[]" value="{{$e->equipment_id}}"> 
							</td>
						</tr>
					@endforeach
				@endif
			</table>
		</div>
</div>

<div class="col-md-10"><hr></div>
