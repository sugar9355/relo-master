@extends('user.layout.app')

@section('styles')
    
@endsection

@section('content')
<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">

<div class="container my-5"> 
    <h4 class="text-center text-uppercase">Select Insurance Type</h4>
        <hr>

		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

			{{ csrf_field() }}

			<div class="row my-4">
			<div class="col-md-12">

			<div class="card card-body">
				<select name="insurance_type" id="insurance_type" class="form-control">
					@foreach ($insuranceCategories as $insuranceCategory)
						<option value="{{ $insuranceCategory->id }}" title="{{ explode(':',$insuranceCategory->ratio)[1] }}">{{ $insuranceCategory->name }}</option>
					@endforeach
				</select>
			</div>
			</div>
			</div>
				
				@if(isset($selected_items[0]))
				<div class="form-row">
				<div class="form-group col-md-12">
				
				<table class="table table-striped table-bordered dataTable dtr-inline">	
					<tr>
						<th>Item</th>
						<th>Image</th>
						<th>Qauntity</th>
						<th>Insurance</th>
						<th width="10%">You Pay</th>
						<th width="10%">We Pay</th>
					</tr>
					@foreach ($insuranceCategories as $insuranceCategory)	
					@endforeach
					@foreach ($selected_items as $k => $item)
						
						<tr>
							<td>
								<span>{{ $item->item_name }}</span>
								<input type="hidden" name="items[{{ $item->pk_booking_item_id }}]" value="{{ $item->pk_booking_item_id }}">
							</td>
							<td>
							
							<img src="{{$item->file_path}}" alt="Item Image" width="50px" height="50px">
							</td>
							<td>
								<span id="{{ $item->quantity }}">({{ $item->quantity }}) x</span>
							</td>
								
							<td>
								<select id="insurance_{{$k+1}}" name="items[{{ $item->pk_booking_item_id }}][insurance]" class="form-control" onchange="set_you_pay({{$k+1}});">
									@foreach ($insuranceCategories as $insuranceCategory)
									
										<option value="{{ $insuranceCategory->id }}" title="{{ explode(':',$insuranceCategory->ratio)[1] }}" 
										@if($item->insurance_id == $insuranceCategory->id) selected @endif >{{ $insuranceCategory->name }}</option>
										
									@endforeach
								</select>
							</td>
							<td>
								<input id="you_pay_{{$k+1}}" class="input-sm form-control" onkeyup="payment({{$k+1}});" name="items[{{ $item->pk_booking_item_id }}][you_pay]" value="{{ $item->you_pay }}">
							</td>
							<td>
								<input id="we_pay_{{$k+1}}" name="items[{{ $item->pk_booking_item_id }}][we_pay]" class="input-sm form-control" value="{{ $item->we_pay }}" readonly>
							</td>
						</tr>
						
					@endforeach
				</table>
				
				</div>
				</div>	
				
				@endif
				
				@php 
					//$property_insurance = array('floor','walls','gates');
				@endphp
				
				<div class="form-row">
				<div class="form-group col-md-12"><h5>Property Insurance</h5><hr></div>
				<div class="form-group col-md-12">
				
				
				<div class="row">
@foreach ($PropertyInsurance as $k => $property)
<div class="col-md-6"> 				
	<div class="card border-warning mb-3 shadow">
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<i class="fas fa-door-open fa-4x text-warning"></i>
				</div>
				<div class="col-md-8 text-right">					
					<h4 class="card-title text-right mb-0">{{ $property->value }}$</h4>
					<h3>{{ $property->name }}</h3>
				</div>
			</div>
			<p class="m-0 mt-2 lead">Insurance to secure the {{ $property->name }} during move as some of {{ $property->name }} are design and decorated with expence and worthy stuffs</p>
		</div>

		<div class="card-footer bg-white d-flex justify-content-between align-items-center py-sm-2">
			
			<div class="custom-control custom-switch">
				  <input name="property_name" type="checkbox" class="custom-control-input" id="property_{{$property->id}}" value="1">
				  <label class="custom-control-label" for="property_{{$property->id}}">Agree to Insure</label>
			</div>
		</div>
	</div>
</div>	
@endforeach
				</div>
				
				</div>	
				</div>	
		
			<div class="col-md-12 text-center">
				<hr>
					<a href="/booking/{{ ($booking->booking_id) ? $booking->booking_id: null }}/5" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark m-auto hvr-icon-wobble-horizontal animated slideInLeft" >Back</a>
					<button name="btn_submit" type="submit" value="6" class="btn btn-dark m-auto hvr-icon-wobble-horizontal animated slideInRight">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
			</div>
			
			
		</form>    
		
</div>

@endsection

@section('scripts')


    <script>
		$(function () 
		{
			$("#insurance_type").on('change', function () 
			{
				var selected_val = $( "#insurance_type option:selected" ).val();		
				$("select[id*='insurance']").val(selected_val);																
			});
			
			// var selected_val = $( "#insurance_type option:selected" ).val();
			
				// $("select[id*='insurance']").val(selected_val);	
		});
		
		function set_you_pay(id)
		{
			var you_pay = $("#you_pay_"+id).val();
			var isn = $( "#insurance_"+id+" option:selected" ).attr("title");
			
			var we_pay = parseInt(you_pay) * parseInt(isn);
			$("#we_pay_"+id).val(we_pay);
			
		}
		function payment(id)
		{
			var you_pay = $("#you_pay_"+id).val();
			var isn = $( "#insurance_"+id+" option:selected" ).attr("title");
			
			var we_pay = parseInt(you_pay) * parseInt(isn);
			$("#we_pay_"+id).val(we_pay);
			
		}
		
    </script>
	
	<script>
		$(function () 
		{
			$("#ins_prop_type").on('change', function () 
			{
				var selected_val = $( "#ins_prop_type option:selected" ).val();		
				$("select[id*='ins_prop_']").val(selected_val);																
			});
		});
		
		function ins_set_you_pay(id)
		{
			var you_pay = $("#ins_you_pay_"+id).val();
			var isn = $( "#ins_prop_"+id+" option:selected" ).attr("title");
			if(you_pay != '')
			{
				var we_pay = parseInt(you_pay) * parseInt(isn);
				$("#ins_we_pay_"+id).val(we_pay);
			}else{
				$("#ins_we_pay_"+id).val('');
			}
		}
		function ins_payment(id)
		{
			var you_pay = $("#ins_you_pay_"+id).val();
			var isn = $( "#ins_prop_"+id+" option:selected" ).attr("title");
			if(you_pay != '')
			{
				var we_pay = parseInt(you_pay) * parseInt(isn);
				$("#ins_we_pay_"+id).val(we_pay);
			}else{
				$("#ins_we_pay_"+id).val('');
			}
			
		}
		
    </script>
	
@endsection
