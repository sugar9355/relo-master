@extends('admin.layout.base')

@section('title', 'Add Worker ')

@section('content')


<!-- Switchery and card controls -->
						
<div class="card">
<div class="card-header bg-dark header-elements-sm-inline">
<h6 class="card-title">Property Insurance</h6>
<div class="header-elements">
<div class="d-flex justify-content-between">

<div class="list-icons ml-3">
	
</div>
</div>
</div>
</div>
<form action="{{ route('admin.propertyInsurance.store') }}" method="post" enctype="multipart/form-data" class="w-100">
{{ csrf_field() }}

<div class="card-body">

<div class="row mb-3">
	<div class="col-md-6">
		<label>Property Name</label>	
		
		<input type="text" name="name" class="form-control" value="" >
	</div>
</div>
<div class="row">
	<div class="col-md-6">
			<label>dollar Value</label>
			<input type="number" name="value" class="form-control" value="" placeholder="$">	
	</div>
</div>


</div>


<div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center">

<div class="mt-2 mt-sm-0">
<button type="submit" name="btn_submit" value="true" class="btn bg-indigo-400"><i class="icon-checkmark3 mr-2"></i> Save</button>
<a href="{{ route('admin.propertyInsurance.index') }}" type="button" class="btn btn-light ml-1"><i class="icon-cross2 mr-2"></i> Close</a>
</div>
</div>

</div>
</form>
<!-- /switchery and card controls -->

	

@endsection
