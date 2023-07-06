<div class="modal-content  modal-lg">

	  <div class="modal-header">
		<h4 class="modal-title">Update Banking Details</h4>
	  </div>
	  
	  <div class="modal-body">
	  
	<form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
	{{csrf_field()}}
	<input type="hidden" name="_method" value="PATCH">
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Beneficiary</label>
			<input class="form-control" type="text" value="@isset($payment_info->beneficiary){{$payment_info->beneficiary}}@endisset" name="beneficiary" required id="beneficiary" placeholder="Beneficiary">
			
		</div>

		<div class="form-group">
			<label>Bank Account</label>
			<input class="form-control" type="text" value="@isset($payment_info->bank_account) {{ $payment_info->bank_account }} @endisset" name="bank_account" required id="bank_account" placeholder="bank_account">
		</div>

		<div class="form-group">
			<label>Paypal Account</label>
			<input class="form-control" type="text" value="@isset($payment_info->paypal_account) {{ $payment_info->paypal_account }} @endisset" name="paypal_account" required id="paypal_account" placeholder="paypal_account">
			
		</div>
		
		<div class="form-group">
			<label>Address</label>
			<input class="form-control" type="text" value="@isset($payment_info->address) {{ $payment_info->address }} @endisset" name="address" required id="address" placeholder="address">
		</div>
		
	</div>
	<div class="col-md-6">
	
		<div class="form-group">
			<label>Country</label>
			<input class="form-control" type="text" value="@isset($payment_info->country) {{ $payment_info->country }} @endisset" name="country" required id="country" placeholder="country">
		</div>
		
		<div class="form-group">
			<label>State</label>
			<input class="form-control" type="text" value="@isset($payment_info->state) {{ $payment_info->state }} @endisset" name="state" required id="state" placeholder="state">
		</div>
		
		<div class="form-group">
			<label>City</label>
			<input class="form-control" type="text" value="@isset($payment_info->city) {{ $payment_info->city }} @endisset" name="city" required id="city" placeholder="city">
		</div>
		
		<div class="form-group">
			<label>ZipCode</label>
			<input class="form-control" type="text" value="@isset($payment_info->zipcode) {{ $payment_info->zipcode }} @endisset" name="zipcode" required id="zipcode" placeholder="zipcode">
		</div>
		
		
	</div>
	</div>
	<div class="d-flex justify-content-start align-items-center">
			<button type="submit"  name="update_payment_info" class="btn bg-blue" name="update_employee" value="true">Update Banking Information <i class="icon-paperplane ml-2"></i></button>
		</div>
</form>

</div>
</div>
