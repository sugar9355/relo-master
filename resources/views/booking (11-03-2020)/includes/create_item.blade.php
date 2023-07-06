<div id="create_item" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h5 class="m-0">Create New Item</h5>
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<div class="modal-body">

<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
	{{csrf_field()}}
	
		<input name="create_item" type="hidden" class="btn btn-success" value="true">
		<div class="form-row">
				<div class="form-group col-md-6 mb-0">
					<strong>Inventroy Item Name:</strong> <input class="form-control" min=0 type="text" name="name" value="" required >
				</div>
				<div class="form-group col-md-6 mb-0">
				@if(isset($categories[0]))
					
					<strong>Item Category Name:</strong> 
					<select name="category" class="form-control" required>
					@foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach
					</select>
				@endif
				</div>
		</div>
		<hr>
		<div class="form-group col-md-12 d-flex mb-0 justify-content-center">
				<div class="form-group col-md-2 text-center mb-0"><strong>breadth</strong></div> 
				<div class="form-group col-md-2 text-center mb-0"><strong>Height</strong></div> 
				<div class="form-group col-md-2 text-center mb-0"><strong>Width</strong></div> 
				
				<div class="form-group col-md-2 text-center mb-0"><strong>Volume</strong></div> 
				<div class="form-group col-md-2 text-center mb-0"><strong>Weight</strong></div> 
		</div>
		<div class="form-group col-md-12 d-flex mb-0 justify-content-center">
				<div class="form-group col-md-2 mb-0">
					<input class="form-control mb-0" min=0 type="number" name="breadth" value="10" required>
				</div> 
				<div class="form-group col-md-2 mb-0">
					<input class="form-control mb-0" min=0 type="number" name="height" value="10" required>
				</div>
				<div class="form-group col-md-2 mb-0">
					<input class="form-control mb-0" min=0 type="number" name="width" value="10" required>
				</div>
				
				<div class="form-group col-md-2 mb-0">
					<input class="form-control mb-0" min=0 type="number" name="volume" value="10" required disabled>
				</div>
				
				<div class="form-group col-md-2 mb-0">
					<input class="form-control mb-0" min=0 type="number" name="weight" value="10" required>
				</div>
		</div>
		<hr>
		<div class="form-row">
		<!-- 
			<table>
			<tr class="text-center"><th></th><th>Flight 0</th><th>Flight 1</th><th>Flight 2</th><th>Flight 3</th><th>Flight 4</th><th>Flight 5</th><th>Flight 6</th></tr>
			<tr>
				<td><strong>MIN</strong></td>
				<td><input class="form-control" min=0 type="number" name="time_0_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_1_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_2_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_3_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_4_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_5_min" value="1" required></td>
				<td><input class="form-control" min=0 type="number" name="time_6_min" value="1" required></td>
			</tr>
			<tr>
				<td><strong>MED</strong></td>
				<td><input class="form-control" min=0 type="number" name="time_0_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_1_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_2_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_3_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_4_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_5_med" value="2" required></td>
				<td><input class="form-control" min=0 type="number" name="time_6_med" value="2" required></td>
			</tr>
			<tr>
				<td><strong>MAX</strong></td>
				<td><input class="form-control" min=0 type="number" name="time_0_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_1_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_2_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_3_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_4_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_5_max" value="3" required></td>
				<td><input class="form-control" min=0 type="number" name="time_6_max" value="3" required></td>
			</tr>
			</table>
				-->
		</div>
		<hr>
		<div class="form-row">
				<div class="form-group col-md-12"><strong>Image Upload</strong></div> 
		</div>
		<div class="form-row">
		 <div class="custom-file">
			<input type="file" class="custom-file-input" name="picture" id="picture">
			<label class="custom-file-label" for="customFile">Choose file</label>
		  </div>
		</div>
		<hr>
		<!--
		<table width="100%">
			<tr>
			<td width="60%">A - basic metal frame</td>
			<td class="text-right"><input class="form-control" type="number" name="R_A"  required id="R_A" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">B - locking joints, no tools required</td>
			<td class="text-right"><input class="form-control" type="number" name="R_B"  required id="R_B" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">C - requires 1 tool (i.e allen key)</td>
			<td class="text-right"><input class="form-control" type="number" name="R_C"  required id="R_C" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">D - requires multiple tools and has many pieces</td>
			<td class="text-right"><input class="form-control" type="number" name="R_D"  required id="R_D" placeholder="Ranking Time of Selected Inventory Item" value="1"></td width="30%"><td></td></tr>
			<tr>
			<td width="60%">E - full IKEA out-of-box assembly; 4-poster bed trundle</td>
			<td class="text-right"><input class="form-control" type="number" name="R_E"  required id="R_E" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			
		</table>
		-->
		<div class="form-group">
			<label class="form-label"><strong>What needs to be disassembled/reassembled?</strong><br>
					Please specify the item and the level of complexity from 1-5, i.e "bed frame, level 2"</label>
				
		</div>
		<table width="100%">
			<tr>
			<td width="60%">A - basic metal frame</td>
			<td class="text-right"><input class="form-control" type="checkbox" name="R_A"  required id="R_A" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">B - locking joints, no tools required</td>
			<td class="text-right"><input class="form-control" type="checkbox" name="R_B"  required id="R_B" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">C - requires 1 tool (i.e allen key)</td>
			<td class="text-right"><input class="form-control" type="checkbox" name="R_C"  required id="R_C" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			<tr>
			<td width="60%">D - requires multiple tools and has many pieces</td>
			<td class="text-right"><input class="form-control" type="checkbox" name="R_D"  required id="R_D" placeholder="Ranking Time of Selected Inventory Item" value="1"></td width="30%"><td></td></tr>
			<tr>
			<td width="60%">E - full IKEA out-of-box assembly; 4-poster bed trundle</td>
			<td class="text-right"><input class="form-control" type="checkbox" name="R_E"  required id="R_E" placeholder="Ranking Time of Selected Inventory Item" value="1"></td><td width="30%"></td></tr>
			
		</table>

		<hr>
		
		
		<hr>
		
	<div class="modal-footer">
		<button name ="btn_submit" type="submit" class="btn btn-success" value="5">Add Item</button>
		<button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
	</div>
</form>
</div>
</div>

</div>
</div>

