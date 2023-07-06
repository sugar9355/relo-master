@extends('user.layout.app')

@section('styles')
 
@endsection

@section('content')

<div class="container my-5"> 
    <h4 class="text-center text-uppercase">Select Insurance Type</h4>
        <hr>
		<div class="form-row">
				<div class="form-group col-md-2 text-center">
					<div class="custom-control custom-switch">
					  <input type="checkbox" class="custom-control-input" id="pakaging_all" value="1">
					  <label class="custom-control-label" for="pakaging_all">Packaging</label>
					</div>
				</div>
				
				<div class="form-group col-md-3 text-center">
					<div class="custom-control custom-switch">
					  <input type="checkbox" class="custom-control-input" id="junk_all" value="1">
					  <label class="custom-control-label" for="junk_all">Junk Removal</label>
					</div>
				</div>
		</div>
	
		
		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

			{{ csrf_field() }}
				
				@if(isset($selected_items[0]))
				<div class="row mb-4">
				
				
					@foreach ($selected_items as $item)

					<div class="col-md-3 animated slideInLeft">

						<div class="card card-body pb-1 hvr-shadow w-100">
							<div class="d-block border-bottom pb-1 mb-2">
								<strong>{{ $item->item_name }}</strong> <span class="float-right" id="{{ $item->quantity }}">x ({{ $item->quantity }})</span>
							</div>

							<div class="d-block text-center">
								<img src="/{{ $item->item_image }}" alt="Item Image" width="20%" class="h-auto m-auto">
							</div>

							<div class="form-group m-0 mt-1">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="{{ $item->item_name }}pkg" name="items[{{ $item->booking_item_id }}][pakaging]" value="1">
								  <label class="custom-control-label" for="{{ $item->item_name }}pkg">Packaging</label>
								</div>
							</div>

							<div class="form-group m-0">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="{{ $item->item_name }}jnkr" name="items[{{ $item->booking_item_id }}][junk_removal]" value="1">
								  <label class="custom-control-label" for="{{ $item->item_name }}jnkr">Junk Removal</label>
								</div>
							</div>

						</div>

					</div>
						
						
						
					@endforeach
				
				</div>
			
				
				@endif
				
				
         
            <input type="hidden" name="accuracy" id="accuracy" value="Not Accurate">

            <!-- Row 1 -->
            <div class="row mb-4">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="card card-body">
	                    <h4 class="m-0">Please select inventory accuracy:</h4>
	                    <hr>
	               		<p>
	                    Please be as helpful as possible in this category.
	                        We understand that estimating is hard so image
	                        estimating your job from your estimate. <strong>NOT EASY!</strong></p>
	                </div>
                </div>
            </div>
    
     
            <div class="row">
                <div class="col-md-3">

                	<div class="card card-body hvr-shadow w-100">
                		<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="accuracy-1" name="accuracy" class="custom-control-input" value="Not Accurate">
						  <label class="custom-control-label font-weight-bold" for="accuracy-1">Not Accurate</label>
						</div>
						<p class="border-top pt-2 my-2">Have Not packed or not sure</p>
                	</div>

               	</div>


               	<div class="col-md-3">

                	<div class="card card-body hvr-shadow w-100">
                		<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="accuracy-2" name="accuracy" class="custom-control-input" value="Somewhat Accurate">
						  <label class="custom-control-label font-weight-bold" for="accuracy-2">Somewhat Accurate</label>
						</div>
						<p class="border-top pt-2 my-2">Most of the big stuff</p>
                	</div>

               	</div>

               	<div class="col-md-3">

                	<div class="card card-body hvr-shadow w-100">
                		<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="accuracy-3" name="accuracy" class="custom-control-input" value="Accurate">
						  <label class="custom-control-label font-weight-bold" for="accuracy-3">Accurate</label>
						</div>
						<p class="border-top pt-2 my-2">Plus or minus a few items</p>
                	</div>

               	</div>

               	<div class="col-md-3">

                	<div class="card card-body hvr-shadow w-100">
                		<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="accuracy-4" name="accuracy" class="custom-control-input" value="Very Accurate">
						  <label class="custom-control-label font-weight-bold" for="accuracy-4">Very Accurate</label>
						</div>
						<p class="border-top pt-2 my-2">Inventory 100% accurate</p>
                	</div>

               	</div>



            </div>
			
   
		
			<div class="col-md-12 text-center">
			<hr>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal animated slideInLeft" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
				<button name="btn_submit" type="submit" value="preview" class="btn btn-warning m-auto hvr-icon-wobble-horizontal px-5 animated slideInRight">preview <i class="far fa-smile-wink hvr-icon"></i></button>
			</div>
			
			
			
		</form>    
		
</div>

@endsection

@section('scripts')


    <script>
		$(function () {
			$("#pakaging_all").on('click', function () 
			{
				if($(this).prop("checked") == true)
				{
					$("input[id*='pkg']").prop( "checked", true );				
				}
				else if($(this).prop("checked") == false)
				{
					$("input[id*='pkg']").prop( "checked", false );				
				}
				
			})
		});
		$(function () {
			$("#junk_all").on('click', function () 
			{
				if($(this).prop("checked") == true)
				{
					$("input[id*='jnkr']").prop( "checked", true );				
				}
				else if($(this).prop("checked") == false)
				{
					$("input[id*='jnkr']").prop( "checked", false );				
				}
				
			})
		});
    </script>
@endsection
