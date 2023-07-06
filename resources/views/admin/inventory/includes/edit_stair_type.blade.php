<div class="card" id="stair_type_item">

	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Stair Time Required to Move item</h6>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
			</div>
		</div>
	</div>

	<div class="card-body">



		<div class="form-group row m_b">

			<div class="2 ml-2">

				<table>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type
								Windy?</label></td>
						<td><input class="form-control " type="number" name="stair_time_windy" min="0"
								value="{{$inventory->stair_windy}}" required id="stair_time_windy" placeholder="Time" step="0.01">
						</td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type
								Narrow?</label></td>
						<td><input class="form-control " type="number" name="stair_time_narrow" min="0"
								value="{{$inventory->stair_narrow}}" required id="stair_time_narrow" placeholder="Time" step="0.01">
						</td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type
								Wide?</label></td>
						<td><input class="form-control " type="number" name="stair_time_wide" min="0"
								value="{{$inventory->stair_wide}}" required id="stair_time_wide" placeholder="Time" step="0.01">
						</td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type
								Spiral?</label></td>
						<td><input class="form-control " type="number" name="stair_time_spiral" min="0"
								value="{{$inventory->stair_spiral}}" required id="stair_time_spiral" placeholder="Time" step="0.01">
						</td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type
								Passenger?</label></td>
						<td><input class="form-control " type="number" name="elevator_time_passenger" min="0"
								value="{{$inventory->elevator_passenger}}" required id="elevator_time_passenger"
								placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type
								Freight?</label></td>
						<td><input class="form-control " type="number" name="elevator_time_freight" min="0"
								value="{{$inventory->elevator_freight}}" required id="elevator_time_freight"
								placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type
								Reserved Freight?</label></td>
						<td><input class="form-control " type="number" name="elevator_time_rs_freight" min="0"
								value="{{$inventory->elevator_reserved_freight}}" required
								id="elevator_time_rs_freight" placeholder="Time" step="0.01"></td>
					</tr>
				</table>

			</div>
		</div>

	</div>
</div>

@for ($i = 2; $i <= 4; $i++)
<div id="stair_type_item_{{$i}}" class="card" style="display: none">

	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Stair Time Required to Move item</h6>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
			</div>
		</div>
	</div>

	<div class="card-body">



		<div class="form-group row m_b">

			<div class="2 ml-2">

				<table>
					@if ($extra_stair_data != [])
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Windy?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_windy[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['stair_windy']}}" id="stair_time_windy" placeholder="Time" step="0.01"> </td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Narrow?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_narrow[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['stair_narrow']}}" id="stair_time_narrow" placeholder="Time" step="0.01"> </td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Wide?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_wide[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['stair_wide']}}" id="stair_time_wide" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Spiral?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_spiral[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['stair_spiral']}}" id="stair_time_spiral" placeholder="Time" step="0.01">
						</td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Passenger?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_passenger[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['elevator_passenger']}}" id="elevator_time_passenger" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Freight?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_freight[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['elevator_freight']}}" id="elevator_time_freight" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Reserved Freight?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_rs_freight[{{$i}}]" min="0" value="{{$extra_stair_data[$i]['elevator_reserved_freight']}}" id="elevator_time_rs_freight" placeholder="Time" step="0.01"></td>
					</tr>
					@else
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Windy?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_windy[{{$i}}]" min="0" value="1" id="stair_time_windy" placeholder="Time" step="0.01"> </td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Narrow?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_narrow[{{$i}}]" min="0" value="1" id="stair_time_narrow" placeholder="Time" step="0.01"> </td>
						<td></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Wide?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_wide[{{$i}}]" min="0" value="1" id="stair_time_wide" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Staris Type Spiral?</label></td>
						<td><input class="form-control " type="number" name="w_stair_time_spiral[{{$i}}]" min="0" value="1" id="stair_time_spiral" placeholder="Time" step="0.01">
						</td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Passenger?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_passenger[{{$i}}]" min="0" value="1" id="elevator_time_passenger" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Freight?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_freight[{{$i}}]" min="0" value="1" id="elevator_time_freight" placeholder="Time" step="0.01"></td>
					</tr>
					<tr>
						<td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Elevator Type Reserved Freight?</label></td>
						<td><input class="form-control " type="number" name="w_elevator_time_rs_freight[{{$i}}]" min="0" value="1" id="elevator_time_rs_freight" placeholder="Time" step="0.01"></td>
					</tr>
					@endif
				</table>



			</div>
		</div>

	</div>
</div>
@endfor