@extends('admin.layout.base')
@section('title', 'Request details ')

@section('content')

<div class="col-md-12">
<div class="card">
	<div class="card-header header-elements-inline">
		<h6 class="card-title">Job Details</h6>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item" data-action="reload"></a>
				<a class="list-icons-item" data-action="remove"></a>
			</div>
		</div>
	</div>

	<div class="card-body">
		<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
			<li class="nav-item"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab">Service Type</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab">Date & Time</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab3" class="nav-link" data-toggle="tab">Pick & Drop</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab4" class="nav-link" data-toggle="tab">Inventory Items</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab5" class="nav-link" data-toggle="tab">Insurance</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab6" class="nav-link" data-toggle="tab">Assigned Truck</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab7" class="nav-link" data-toggle="tab">Time Factors</a></li>
			<li class="nav-item"><a href="#highlighted-justified-tab8" class="nav-link" data-toggle="tab">Available Captain</a></li>
			
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade " id="highlighted-justified-tab1">
				@include('admin.movingRequest.tabs.service_type') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab2">
				@include('admin.movingRequest.tabs.date_time') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab3">
				@include('admin.movingRequest.tabs.location') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab4">
				@include('admin.movingRequest.tabs.inventory') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab5">
				@include('admin.movingRequest.tabs.insurance') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab6">
				@include('admin.movingRequest.tabs.assigned_truck') 
			</div>
			<div class="tab-pane fade show active" id="highlighted-justified-tab7">
				@include('admin.movingRequest.tabs.time_factor') 
			</div>
			<div class="tab-pane fade" id="highlighted-justified-tab8">
				@include('admin.movingRequest.tabs.assigned_captain') 
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
