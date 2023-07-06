<div id="item_add_{{ $item->id }}" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">

<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

		{{csrf_field()}}

		<input type="hidden" name="item_id" value="{{ $item->id }}">
		<input type="hidden" name="item_name" value="{{ $item->name }}">
		<input type="hidden" name="item_image" value="{{ $item->image }}">
		<input type="hidden" name="file_path" value="{{ $item->file_path }}">

<div class="modal-header text-white bg-info">
	<h3 class="m-0">{{ $item->name }}</h3>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<div class="text-center">
	<img src="{{$item->file_path}}" height="100px" width="100px" alt="">
</div>	



	
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
		
		@if(!empty($booking_location))
			@foreach($booking_location as $k => $loc)
				@if($k == 0)
				<input type="hidden" name="pick_up_loc_id" value="{{$loc->booking_loc_id}}">
				@elseif($k == (count($booking_location) - 1))
				<input type="hidden" name="drop_off_loc_id" value="{{$loc->booking_loc_id}}">
				@endif
			@endforeach
		@endif
</div>
	<div class="modal-footer">
		<button name ="btn_submit" type="submit" class="btn btn-success" value="5">Add Item</button>
		<button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
	</div>
	
</form>

</div>

</div>
</div>