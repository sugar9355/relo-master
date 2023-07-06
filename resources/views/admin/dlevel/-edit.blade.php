@extends('admin.layout.base')

@section('title', 'Edit Difficulty Level')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.dlevel.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Update Difficulty Level</h5>

				<form class="form-horizontal" action="{{route('admin.dlevel.update', $dlevel->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.category_name')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $dlevel->name }}" name="name" required id="name" placeholder="Name">
						</div>
					</div>
					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Minutes(Ground To First Floor )</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ $dlevel->time }}" name="time" required id="time"
                                   placeholder="5">
                        </div>

                    </div>





					<div class="form-group">
						<label for="flag" class="col-md-12 col-form-label">Level Type</label>
						<div class="col-md-10">
							<select name="level" class="form-control">
							<option selected>{{ $dlevel->level }} </option>
								<option value="Level 0  ">Level 0 </option>
								<option value="Level 1 ">Level 1 </option>
                                <option value="Level 2 ">Level 2 </option>
                                <option value="Level 3 ">Level 3 </option>
                                <option value="Level 4 ">Level 4 </option>
                                <option value="Level 5 ">Level 5 </option>
                            
                            
                            
                            
                            </select>
						</div>
					</div>


					
					<div class="form-group">
						<label for="weight" class="col-md-12 col-form-label">@lang('admin.item_ids')</label>
						<div class="col-md-10">
							<input type="hidden" id="itemIdsVal" value="{{$dlevel->item_ids}}">
							<select class="select2 form-control" multiple name="item_ids[]">
								@foreach( $items as $item)
									<option value="{{ $item->name }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">Stairs</label>
						
						<div class="col-md-10">
							<select name="stairs" class="form-control">
							<option selected>{{ $dlevel->stairs }} </option>
								<option value="0 To 1">0 To 1</option>
								<option value="1 to 2">1 to 2</option>
								<option value="2 To 3">2 To 3</option>
								<option value="3 To 4">3 To 4</option>
								<option value="4 To 5">4 To 5</option>
							</select>
						
						</div>
					</div>
					<div class="form-group">
						<label for="flag" class="col-md-12 col-form-label">Stair Type</label>
						<div class="col-md-10">
							<select name="stairs_t" class="form-control">
							<option selected>{{ $dlevel->stairs_t }} </option>
								<option value="Windy">Windy</option>
								<option value="Narrow">Narrow</option>
								<option value="Both">Both</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">Update Difficulty Level</button>
							<a href="{{route('admin.dlevel.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
@section('scripts')
<script>
	$(function(){
		let selector = $('.select2');
		selector.select2();
		let selected = $('#itemIdsVal').val().split(",");
		selector.val(selected);
		selector.change();
	});

	function addToDescription(me, resDiv) {
		let val = $(me).val().join(',');
		$(resDiv).val(val);
	}
</script>
<script>
	$(function(){
		$('.redio').on('click', function(event){
			$('.active').removeClass('active fa-circle').addClass('fa-circle-thin');
			let parentSelector = $(event.currentTarget);
			let selector = parentSelector.find('i');
			selector.removeClass('fa-circle-thin');
			selector.addClass('fa-circle active');
			let val = parentSelector.parent().find('h5').text();
			$("#accuracy").val(val);
		})
	});
</script>
@endsection
