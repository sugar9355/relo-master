@extends('admin.layout.base')

@section('title', 'Add Inventory Items')

@section('content')

<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/uploaders/dropzone.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/uploader_bootstrap.js')}}"></script>


<form class="form-horizontal" action="{{route('admin.inventory.store')}}" method="POST" enctype="multipart/form-data">
					
		{{csrf_field()}}

<div class="row">
<div class="col-md-9">
				
	<div class="card">
	
	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Item Details</h6>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
			</div>
		</div>
	</div>
	
	<div class="card-body">
		
		<div class="row">
			<div class="col-md-6">				
				<div class="form-group">
					<label for="name" class="col-form-label">Item Category Name</label>
					<select class="form-control" name="category" id="category" onchange="showCategoryflights();">
						<option value="" selected hidden>Select Category</option>
					@foreach($categories as $category)
						
						<option value="{{ $category->id }}" >{{ $category->name }}</option>
					@endforeach
				</select>
				</div>
			</div>
			<div class="col-md-4">				
				<div class="form-group">
					<label for="name" class="col-form-label">Select Material</label>
					<select class="form-control" name="meterial_type" id="meterial_type">
					@foreach($materials as $material)
						<option value="{{ $material->id }}" >{{ $material->name }}</option>
					@endforeach
				</select>
				</div>
			</div>
				<div class="col-md-2">				
				<div class="form-group">
					<label for="name" class="col-form-label">Select Hoisting</label>
					<div class="form-check form-check-switch form-check-switch-left">
						<label class="form-check-label d-flex align-items-center">
							<input name="hoisting" type="checkbox" value="1" class="form-check-input form-check-input-switch" data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default">
						</label>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name" class="col-form-label">Inventroy Item Name</label>
					<input class="form-control" type="text" value="{{ old('name') }}" name="name"  id="name" placeholder="Name">
				</div>
			</div>
			<div class="col-md-6">				
				<div class="form-group">
					<label for="name" class="col-form-label">Equipment Required</label>
					<select name="equipment[]" id="equipment" multiple="multiple" class="form-control select" data-fouc>
						@foreach($equipments as $equipment)
							<option value="{{ $equipment->id }}" >{{ $equipment->name }}</option>
						@endforeach
					</select>
				</select>
				</div>
			</div>
		</div>

	</div>
	</div>
	
	
</div>

	<div class="col-md-3">
		<div class="card">
			<div class="card-body">

					<div class="row row-tile no-gutters">
						<input type="file" name="file" class="file-input form-control-sm" data-show-caption="false" data-show-upload="false" data-browse-class="btn btn-primary btn-sm" data-remove-class="btn btn-light btn-sm" data-fouc>
					</div>

			</div>
		</div>
		

	</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
	<h6 class="card-title">Item Dimension</h6>
	<div class="header-elements">
		<div class="list-icons">
			<a class="list-icons-item" data-action="collapse"></a>
		</div>
	</div>
</div>
<div class="card-body">
<div class="row">
		<div class="col-md-12">
			<div class="form-inline">
				<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.weight')</label></div>
				<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.width')</label></div>
				<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.height')</label></div>
				<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.breadth')</label></div>
				<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.volume')</label></div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-inline">
				<div class="col-md-2"><input class="form-control text-center" onkeyup="total_volume();" type="text" value="{{ old('weight') }}"  name="weight"  id="weight" placeholder="Weight"></div>
				<div class="col-md-2"><input class="form-control text-center" onkeyup="total_volume();" type="text" value="{{ old('width') }}"   name="width"  id="width" placeholder="Width"></div>
				<div class="col-md-2"><input class="form-control text-center" onkeyup="total_volume();" type="text" value="{{ old('height') }}"  name="height"  id="height" placeholder="Height"></div>
				<div class="col-md-2"><input class="form-control text-center" onkeyup="total_volume();" type="text" value="{{ old('breadth') }}" name="breadth"  id="breadth" placeholder="Breadth"></div>
				<div class="col-md-2"><input class="form-control text-center" onkeyup="total_volume();" type="text" value="{{ old('volume') }}" name="volume"  id="volume" placeholder="Volume" readonly></div>
			</div>
		</div>
	</div>
</div>	
</div>

<div id="card_item" class="card">

<div class="card-header bg-dark text-white header-elements-inline">
	<h6 class="card-title">Category Flights</h6>
	<div class="header-elements">
		<div class="list-icons">
			<a class="list-icons-item" data-action="collapse"></a>
		</div>
	</div>
</div>
<div class="card-body">
	<!-- Ranking -->
		@include('admin.inventory.includes.add_flights') 
	<!-- Ranking -->
</div>
</div>
	

@foreach($categories as $category)
<div id="card_{{$category->id}}" class="card" style="display:none;">

<div class="card-header bg-dark text-white header-elements-inline">
	<h6 class="card-title">Category Flights ( {{$category->name}} )</h6>
	<div class="header-elements">
		<div class="list-icons">
			<a class="list-icons-item" data-action="collapse"></a>
		</div>
	</div>
</div>
<div class="card-body">
	<!-- Ranking -->
		@include('admin.inventory.includes.add_flights') 
	<!-- Ranking -->
</div>
</div>
@endforeach
		
	
@php $index = 1; @endphp
@foreach($categories as $category)

		<div id="question_{{$category->id}}" class="card"  style="display:none;">
		<div class="card-header bg-dark text-white header-elements-inline">
			<h6 class="card-title">Category Question ( {{$category->name}} )</h6>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="collapse"></a>
				</div>
			</div>
		</div>
		
		<div class="card-body">
		@foreach($category_questions as $k => $question)		
		@if($question->category_id == $category->id)
			
			<!-- Category Question -->
			
				<div class="form-group">
					
					<div class="row">
						<div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . ({{$index}}) </label></div>
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{$question->title}}" name="category_question[{{$question->question_id}}]" readonly>
						</div>
						<div class="col-md-1 pt-1">
							<div class="form-check form-check-switchery">
								<label class="form-check-label">
									<input name="check_question[]" type="checkbox" class="form-check-input-switchery" value="{{$question->question_id}}" data-fouc>
									select
								</label>
							</div>
						</div>
					</div>
				</div>
				@php $index = $index + 1; @endphp
		@endif
		@endforeach
			<!-- Category Question -->
		</div>
		</div>

@endforeach

<div class="card">
		<div class="card-header bg-dark text-white header-elements-inline">
			<h6 class="card-title">Inventory Questions</h6>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="collapse"></a>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div id="questions" class="card-body">
				<div class="form-group">
					
					<div class="row">
						<div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . (1) </label></div>
						<div class="col-md-8">
							<input class="form-control" type="text" value="" name="question[]" placeholder="Enter Question text"  >
						</div>
						<div class="col-md-2">
							<button id="btn_add" type="button" class="btn btn-success">Add More</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	
<div class="row">
	<div class="col-md-6">
	<!-- Ranking -->
		@include('admin.inventory.includes.add_ranking') 
	<!-- Ranking -->
	</div>
	<div class="col-md-6">
	<!-- Stairs Type -->
		@include('admin.inventory.includes.add_stair_type') 
	<!-- Stairs Type -->
	</div>
</div>
	
<div class="card">
<div class="card-body">
			
	<button type="submit" class="btn btn-primary">Create Item <i class="icon-paperplane"></i> </button>
	<a href="{{route('admin.inventory.index')}}" class="btn btn-default btn-outline-dark">@lang('admin.cancel')</a>
	
</div>
</div>
</form>


<!-- Modal -->
<div id="upload_picture" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
	  <h4 class="modal-title">Upload Items Picture</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
	  </div>
	  <div class="modal-body">
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>

<!-- Modal -->
<div id="sample_download" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
	  <h4 class="modal-title">Download Excel Sheet</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
	  </div>
	  <div class="modal-body">
	  
	
	  
		<form class="form-horizontal" action="{{route('admin.inventory.store')}}" method="POST" enctype="multipart/form-data" role="form">
			{{csrf_field()}}
			
			
			
		</form>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>

<!-- Modal -->
<div id="upload_excel_sheet" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
	  <h4 class="modal-title">Upload Excel Sheet</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
	  </div>
	  <div class="modal-body">
	  
		
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>

<script>

	$(function()
	{
		var index = 1;
		$("#btn_add").on('click', function()
		{
			index = index + 1;
			var res  = '<div id="div_'+index+'" class="form-group">';
				res += '<div class="row">';
				res += '<div class="col-md-1 text-right"><label for="name" class="col-form-label">Q . ('+index+') </label></div>';
				res += '<div class="col-md-8">';
				res += '<input class="form-control" type="text" value="" name="question[]"  id="question_'+index+'" placeholder="Enter Question text">';
				res += '</div><div class="col-md-2">';
				res += '<button class="btn btn-danger col-md-6" type="button" onclick="remove_q('+index+')">Remove</button>';
				res += '</div></div></div>';
			
			$("#questions").append(res);
		});
	});
	
	function remove_q(index)
	{
		$("#div_"+index).empty();
	}
	
	function showCategoryflights()
	{
		var category = $("#category").val();
		
		$( "div[id*='card_']" ).hide();
		
		$( "div[id*='question_']" ).hide();
		
		$("#card_"+category).fadeIn("slow");
		$("#card_"+category).fadeIn(1000);	
		
		$("#question_"+category).fadeIn("slow");
		$("#question_"+category).fadeIn(1000);	
		
	}
	
	function total_volume()
	{
		var width = $("#width").val();
		var height = $("#height").val();
		var breadth = $("#breadth").val();
		
		var volume = width * height * breadth;
		
		$("#volume").val(volume);
		
	}

    </script>

@endsection
