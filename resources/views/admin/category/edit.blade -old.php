@extends('admin.layout.base')

@section('title', 'Edit Item Category')

@section('content')

<style>

.zero 
{	
	padding-top:0px; 
	padding-bottom:0px; 
	margin-bottom:0px; 
	margin-top:0px;

}

.h_w
{
	margin-left:1px; 
	padding-left:0px; 
	padding-right:0px; 
	width: 140%;
	text-align:center;
}

.input_w
{
	float:left; 
	width: 11%;
	padding:0px 1px 0px 1px; 
	margin:0px 6px 0px 5px; 
	text-align:center;
	
}

.lbl_w
{
	float:left; 
	width: 16%;
	padding:0px 1px 0px 1px; 
	margin:0px 4px 0px 5px; 
	text-align:center;
	
}

.m_b
{
	margin-bottom:0px; 
}

</style>

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.category.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Update Item Category</h5>

				<form class="form-horizontal" action="{{route('admin.category.update', $category->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.category_name')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $category->name }}" name="name" required id="name" placeholder="Name">
						</div>
					</div>
					
	<div class="form-group row zero">
		<div class="col-md-10"><hr></div>
		<div class="col-md-12">
		
			@for ($i = 0; $i <= 6; $i++)
				<div class="input_w">
					<label for="name" class="col-md-12 col-form-label">Flight {{$i}}</label>
				</div>
			@endfor
		</div>
	</div>
	
	<div class="form-group row ">
		<div class="col-md-12">
			<input class="form-control input_w" type="number" value="{{ old('time_0_min') }}{{ $category->time_0_min }}" name="time_0_min" required id="time_0_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_1_min') }}{{ $category->time_1_min }}" name="time_1_min" required id="time_1_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_2_min') }}{{ $category->time_2_min }}" name="time_2_min" required id="time_2_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_3_min') }}{{ $category->time_3_min }}" name="time_3_min" required id="time_3_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_4_min') }}{{ $category->time_4_min }}" name="time_4_min" required id="time_4_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_5_min') }}{{ $category->time_5_min }}" name="time_5_min" required id="time_5_min" placeholder="Minimum">
			<input class="form-control input_w" type="number" value="{{ old('time_6_min') }}{{ $category->time_6_min }}" name="time_6_min" required id="time_6_min" placeholder="Minimum">
		</div>	
	</div>
	
	<div class="form-group row ">
		<div class="col-md-12">
			<input class="form-control input_w" type="number" value="{{ old('time_0_med') }}{{ $category->time_6_med }}" name="time_0_med" required id="time_0_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_1_med') }}{{ $category->time_6_med }}" name="time_1_med" required id="time_1_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_2_med') }}{{ $category->time_6_med }}" name="time_2_med" required id="time_2_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_3_med') }}{{ $category->time_6_med }}" name="time_3_med" required id="time_3_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_4_med') }}{{ $category->time_6_med }}" name="time_4_med" required id="time_4_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_5_med') }}{{ $category->time_6_med }}" name="time_5_med" required id="time_5_med" placeholder="medimum">
			<input class="form-control input_w" type="number" value="{{ old('time_6_med') }}{{ $category->time_6_med }}" name="time_6_med" required id="time_6_med" placeholder="medimum">
		</div>	
	</div>
	
	<div class="form-group row ">
		<div class="col-md-12">
			<input class="form-control input_w" type="number" value="{{ old('time_0_max') }}{{ $category->time_6_max }}" name="time_0_max" required id="time_0_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_1_max') }}{{ $category->time_6_max }}" name="time_1_max" required id="time_1_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_2_max') }}{{ $category->time_6_max }}" name="time_2_max" required id="time_2_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_3_max') }}{{ $category->time_6_max }}" name="time_3_max" required id="time_3_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_4_max') }}{{ $category->time_6_max }}" name="time_4_max" required id="time_4_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_5_max') }}{{ $category->time_6_max }}" name="time_5_max" required id="time_5_max" placeholder="maximum">
			<input class="form-control input_w" type="number" value="{{ old('time_6_max') }}{{ $category->time_6_max }}" name="time_6_max" required id="time_6_max" placeholder="maximum">
		</div>	
	</div>

<!-- 


					<table class="table table-striped">
  <thead>
    <tr>
	<center>
      <th scope="col" ></th>
      <th scope="col" style="text-align: center;">0</th>
      <th scope="col" style="text-align: center;">1</th>
      <th scope="col" style="text-align: center;">2</th>
	  <th scope="col" style="text-align: center;">3</th>
	  <th scope="col" style="text-align: center;">4</th>
	  <th scope="col" style="text-align: center;">5</th>
	  <th scope="col" style="text-align: center;">6</th>
	  </center>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"></th>
      <td style="text-align: center;text-align-last: center;
}

"> <input class="" type="number" style="padding: 4px;
    margin-bottom: 6px;"  value="{{ $category->time_o_min }}" name="time_o_min" required id="time"
                                   placeholder="Minimum"> <br/>
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_o_med }}" name="time_o_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_o_max }}" name="time_o_max" required id="time"
                                   placeholder="Maximum"></td>
      <td style="text-align: center;text-align-last: center;
}

"><input class=""  style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_1_min }}" name="time_1_min" required id="time"
                                   placeholder="Minimum">
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_1_med }}" name="time_1_med" required id="time"
                                   placeholder="Medium">
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_1_max }}" name="time_1_max" required id="time"
                                   placeholder="Maximum"></td>
      <td style="text-align: center;text-align-last: center;
}

"><input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{ $category->time_2_min }}" name="time_2_min" required id="time"
                                   placeholder="Minimum">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_2_med }}" name="time_2_med" required id="time"
                                   placeholder="Medium">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_2_max }}" name="time_2_max" required id="time"
                                   placeholder="Maximum"></td>
								  
								   <td style="text-align: center;text-align-last: center;
}

"><input class="" type="number" style="padding: 4px;
    margin-bottom: 6px;"  value="{{ $category->time_3_min }}" name="time_3_min" required id="time"
                                   placeholder="Minimum">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_3_med }}" name="time_3_med" required id="time"
                                   placeholder="Medium">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_3_max }}" name="time_3_max" required id="time"
                                   placeholder="Maximum"></td>
								   <td style="text-align: center;text-align-last: center;
}

"><input class="" type="number" style="padding: 4px;
    margin-bottom: 6px;" value="{{ $category->time_4_min }}" name="time_4_min" required id="time"
                                   placeholder="Minimum">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_4_med }}" name="time_4_med" required id="time"
                                   placeholder="Medium">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_4_max }}" name="time_4_max" required id="time"
                                   placeholder="Maximum"></td>
								   <td style="text-align: center;text-align-last: center;
}
 
"><input class="" type="number" style="padding: 4px;
    margin-bottom: 6px;" value="{{ $category->time_5_min }}" name="time_5_min" required id="time"
                                   placeholder="Minimum">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_5_med }}" name="time_5_med" required id="time"
                                   placeholder="Medium">
								   <input style="padding: 4px;
    margin-bottom: 6px;" class="" type="number"  value="{{ $category->time_5_max }}" name="time_5_max" required id="time"
                                   placeholder="Maximum"></td>

								   <td style="text-align: center;text-align-last: center;
}

"><input class="" type="number" style="padding: 4px;
    margin-bottom: 6px;"  value="{{  $category->time_6_min }}" name="time_6_min" required id="time"
                                   placeholder="Minimum">
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{  $category->time_6_med }}" name="time_6_med" required id="time"
                                   placeholder="Medium">
								   <input class="" style="padding: 4px;
    margin-bottom: 6px;" type="number"  value="{{  $category->time_6_max }}" name="time_6_max" required id="time"
                                   placeholder="Maximum"></td>
    </tr>
    
  </tbody>
</table>









					<!--div class="form-group row">
                        <label for="time" class="col-md-12 col-form-label">Floor 0</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_o_min }}" name="time_o_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_o_med }}" name="time_o_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_o_max }}" name="time_o_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div>

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Floor 1</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_1_min }}" name="time_1_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_1_med }}" name="time_1_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_1_max }}" name="time_1_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div>

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Floor 2</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_2_min }}" name="time_2_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_2_med }}" name="time_2_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_2_max }}" name="time_2_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div>

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Floor 3</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_3_min }}" name="time_3_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_3_med }}" name="time_3_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_3_max }}" name="time_3_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div>

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Floor 4</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_4_min }}" name="time_4_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_4_med }}" name="time_4_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_4_max }}" name="time_4_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div>

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Floor 5</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ $category->time_5_min }}" name="time_5_min" required id="time"
                                   placeholder="Minimum"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_5_med }}" name="time_5_med" required id="time"
                                   placeholder="Medium"><br/>
								   <input class="form-control" type="number"  value="{{ $category->time_5_max }}" name="time_5_max" required id="time"
                                   placeholder="Maximum"><br/>
                        </div>

                    </div-->



					<!--div class="form-group row">
                        <label for="time" class="col-md-12 col-form-label">Time in Minutes(Ground To First Floor )</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ $category->time }}" name="time" required id="time"
                                   placeholder="5">
                        </div>

                    </div>
					<div class="form-group">
						<label for="weight" class="col-md-12 col-form-label">@lang('admin.item_ids')</label>
						<div class="col-md-10">
							<input type="hidden" id="itemIdsVal" value="{{$category->item_ids}}">
							<select class="select2 form-control" multiple name="item_ids[]">
								@foreach( $items as $item)
									<option value="{{ $item->name }}">{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div-->
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.inventory.Update_Item')</button>
							<a href="{{route('admin.category.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
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
