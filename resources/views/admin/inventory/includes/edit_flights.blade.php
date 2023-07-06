<table >
	<tr class="text-center"><th></th><th>Flight 0</th><th>Flight 1</th><th>Flight 2</th><th>Flight 3</th><th>Flight 4</th><th>Flight 5</th><th>Flight 6</th></tr>
	<tr>
		<td><strong>MIN</strong></td>
		<td><input class="form-control" min=0 type="number" name="time_0_min[{{$category->id}}]" value="{{$inventory->time_0_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_1_min[{{$category->id}}]" value="{{$inventory->time_1_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_2_min[{{$category->id}}]" value="{{$inventory->time_2_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_3_min[{{$category->id}}]" value="{{$inventory->time_3_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_4_min[{{$category->id}}]" value="{{$inventory->time_4_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_5_min[{{$category->id}}]" value="{{$inventory->time_5_min}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_6_min[{{$category->id}}]" value="{{$inventory->time_6_min}}" step="0.01" ></td>
	</tr>
	<tr>
		<td><strong>MED</strong></td>
		<td><input class="form-control" min=0 type="number" name="time_0_med[{{$category->id}}]" value="{{$inventory->time_0_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_1_med[{{$category->id}}]" value="{{$inventory->time_1_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_2_med[{{$category->id}}]" value="{{$inventory->time_2_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_3_med[{{$category->id}}]" value="{{$inventory->time_3_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_4_med[{{$category->id}}]" value="{{$inventory->time_4_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_5_med[{{$category->id}}]" value="{{$inventory->time_5_med}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_6_med[{{$category->id}}]" value="{{$inventory->time_6_med}}" step="0.01" ></td>
	</tr>
	<tr>
		<td><strong>MAX</strong></td>
		<td><input class="form-control" min=0 type="number" name="time_0_max[{{$category->id}}]" value="{{$inventory->time_0_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_1_max[{{$category->id}}]" value="{{$inventory->time_1_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_2_max[{{$category->id}}]" value="{{$inventory->time_2_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_3_max[{{$category->id}}]" value="{{$inventory->time_3_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_4_max[{{$category->id}}]" value="{{$inventory->time_4_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_5_max[{{$category->id}}]" value="{{$inventory->time_5_max}}" step="0.01" ></td>
		<td><input class="form-control" min=0 type="number" name="time_6_max[{{$category->id}}]" value="{{$inventory->time_6_max}}" step="0.01" ></td>
	</tr>
	</table>