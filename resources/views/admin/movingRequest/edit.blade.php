@extends('admin.layout.base')
@section('title', 'Request details ')


@section('content')

<div class="card">
<div class="card-body">
<div >

	<div class="row">

	<div class="col-md-12">
	  <h2>Job Details</h2>
	  <p></p>
		<hr>
	  <ul class="nav nav-tabs">
		<li onclick="show_tab(1);" class="active"><a href="#">Service Type</a></li>
		<li><a onclick="show_tab(2);" href="#">Date & Time</a></li>
		<li><a onclick="show_tab(3);" href="#">Pick & Drop</a></li>
		<li><a onclick="show_tab(4);" href="#">Inventory Items</a></li>
		<li><a onclick="show_tab(5);" href="#">Insurance</a></li>
		<li><a onclick="show_tab(6);" href="#">Assigned Truck</a></li>
		<li><a onclick="show_tab(7);" href="#">Time Factors</a></li>
		<li><a onclick="show_tab(8);" href="#">Available Captain</a></li>
	  </ul>

	  <div class="tab-content">
		<div id="tab_1" name="tab_1"style="display:none;" >
		  
		  <div class="form-group"><div class="col-md-12"><h3>Service Type</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.service_type') 
		</div>
		<div id="tab_2" name="tab_2" style="display:none;">
			<div class="form-group"><div class="col-md-12"><h3>Date & Time</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.date_time') 
		</div>
		<div id="tab_3" name="tab_3" style="display:none;">
		 
		  <div class="form-group"><div class="col-md-12"> <h3>Pick & Drop</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.location') 
		</div>
		<div id="tab_4" name="tab_4" style="display:none;">
			<div class="form-group"><div class="col-md-12"><h3>Inventory Items</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.inventory') 
		</div>
		<div id="tab_5" name="tab_5" style="display:none;">
		  <div class="form-group"><div class="col-md-12"><h3>Insurance</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.insurance') 
		</div>
		<div id="tab_6" name="tab_6" style="display:none;">
		  <div class="form-group"><div class="col-md-12"><h3>Assigned Truck</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.assigned_truck') 
		</div>
		<div id="tab_7" name="tab_7" >
		  <div class="form-group"><div class="col-md-12"><h3>Time Factors</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.time_factor') 
		</div>
		<div id="tab_8" name="tab_8" style="display:none;">
		  <div class="form-group"><div class="col-md-12"><h3>Available Captain</h3><hr></div></div>
		  @include('admin.movingRequest.tabs.assigned_captain') 
		</div>
		
		
	  </div>
	</div>

	</div>
	
</div>
</div>
</div>
    
@endsection
<script type="text/javascript">

function show_tab(tab)
{
	$( "div[name*='tab']" ).hide();
	$( "div[name*='tab']" ).removeClass('active');
	
	$('#tab_'+tab).show();
	//$('#tab_'+tab).addClass('active');
	$('#tab_'+tab).addClass("active");
	
}

</script>
