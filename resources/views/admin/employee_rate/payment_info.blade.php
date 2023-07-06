<form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
	{{csrf_field()}}
	<input type="hidden" name="_method" value="PATCH">
				
<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">Beneficiary</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->beneficiary){{$payment_info->beneficiary}}@endisset" name="beneficiary" required id="beneficiary" placeholder="Beneficiary">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label  text-right">Bank Account</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->bank_account) {{ $payment_info->bank_account }} @endisset" name="bank_account" required id="bank_account" placeholder="bank_account">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label  text-right">Paypal Account</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->paypal_account) {{ $payment_info->paypal_account }} @endisset" name="paypal_account" required id="paypal_account" placeholder="paypal_account">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">Address</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->address) {{ $payment_info->address }} @endisset" name="address" required id="address" placeholder="address">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">Country</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->country) {{ $payment_info->country }} @endisset" name="country" required id="country" placeholder="country">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">State</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->state) {{ $payment_info->state }} @endisset" name="state" required id="state" placeholder="state">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">City</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->city) {{ $payment_info->city }} @endisset" name="city" required id="city" placeholder="city">
	</div>
</div>

<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right">Zipcode</label>
	<div class="col-md-10">
		<input class="form-control" type="text" value="@isset($payment_info->zipcode) {{ $payment_info->zipcode }} @endisset" name="zipcode" required id="zipcode" placeholder="zipcode">
	</div>
</div>

   


<div class="form-group">
	<label for="last_name" class="col-md-2 col-form-label text-right"></label>
	<div class="col-md-10">
		<button type="submit" name="update_payment_info" value="true" class="btn btn-primary">Update Banking Information</button>
	</div>
</div>

</form>