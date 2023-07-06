<div id="item_add_{{ $item->id }}" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h3 class="m-0">{{ $item->name }}</h3>
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<div class="modal-body">

<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
	{{csrf_field()}}

	<input type="hidden" name="item_id" value="{{ $item->id }}">
	<input type="hidden" name="item_name" value="{{ $item->name }}">
	<input type="hidden" name="item_image" value="{{ $item->image }}">
	<input type="hidden" name="file_path" value="{{ $item->file_path }}">
	
	
		<div class="form-row">
				<div class="form-group col-md-6">
					<strong>Quantity :</strong> <input class="form-control" min=1 max=10 type="number" name="quantity" value="1">
				</div>
				<div class="form-group col-md-6">
					@if(isset($categories[0]))
						<strong>Item Category Name: {{$item->category_id}}</strong> 
						<select name="category" class="form-control">
						@foreach($categories as $category)
						<option value="{{$category->id}}" @if($item->category_id == $category->id) selected @endif >{{$category->name}}</option>
						@endforeach
						</select>
					@endif
				</div>
		</div>
		
		<hr>
		<div class="form-row">
				<div class="form-group col-md-3 text-center"><strong>Height</strong></div> 
				<div class="form-group col-md-3 text-center"><strong>Width</strong></div> 
				<div class="form-group col-md-3 text-center"><strong>Breadth</strong></div> 
				<div class="form-group col-md-3 text-center"><strong>Weight</strong></div> 
		</div>
		<div class="form-row">
				<div class="form-group col-md-3">
					<input class="form-control" min=0 type="number" name="height" value="{{ $item->height }}">
				</div>
				<div class="form-group col-md-3">
					<input class="form-control" min=0 type="number" name="width" value="{{ $item->width }}">
				</div>
				<div class="form-group col-md-3">
					<input class="form-control" min=0 type="number" name="breadth" value="{{ $item->breadth }}">
				</div>
				<div class="form-group col-md-3">
					<input class="form-control" min=0 type="number" name="weight" value="{{ $item->weight }}">
				</div> 
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
		
		<div class="form-group">
			<label class="form-label"><strong>What needs to be disassembled/reassembled?</strong><br>
					Please specify the item and the level of complexity from 1-5, i.e "bed frame, level 2"</label>
				@if(!empty($ranking))
					<select name="ranking" class="form-control">
					@foreach($ranking as $rank)
							<option value="{{$rank->ranking_id}}">{{$rank->alphabet}} - {{$rank->ranking_name}}</option>
					@endforeach
					</select>
				@endif
		</div>
		<hr>
		<div class="form-row jjjj">			
			
				@if(!empty($question))
					
					@foreach($question as $k => $q)
						
						@if($q->item_id == $item->id)

							<div class="form-group col-md-6">	
							
									<p><strong>Q). {{$q->title}} </strong></p>

									<div class="custom-control custom-radio custom-control-inline">
									  <input type="radio" id="answer[{{$q->id}}]-yes" name="answer[{{$q->id}}]" class="custom-control-input">
									  <label class="custom-control-label" for="answer[{{$q->id}}]-yes">Yes</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
									  <input type="radio" id="answer[{{$q->id}}]-no" name="answer[{{$q->id}}]" class="custom-control-input">
									  <label class="custom-control-label" for="answer[{{$q->id}}]-no">No</label>
									</div>
							
							</div>
						@endif	
						
					@endforeach
					
				@endif
				
			
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-12 text-left">
			<label class="form-label"><strong>Please Select Pickup Location of Seleted item</strong></label>
				@if(!empty($booking_location))
					<select name="pick_up_loc_id" class="form-control">
					@foreach($booking_location as $loc)
							<option value="{{$loc->booking_loc_id}}">{{$loc->location}}</option>
					@endforeach
					</select>
				@endif
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12 text-left">
			<label class="form-label"><strong>Please Select Drop off Location of Seleted item</strong></label>
				@if(!empty($booking_location))
					<select name="drop_off_loc_id" class="form-control">
					@foreach($booking_location as $loc)
							<option value="{{$loc->booking_loc_id}}">{{$loc->location}}</option>
					@endforeach
					</select>
				@endif
			</div>
		</div>
		
	
	<div class="modal-footer">
		<button name ="btn_submit" type="submit" class="btn btn-success" value="5">Add Item</button>
		<button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
	</div>
</form>
</div>
</div>

</div>
</div>