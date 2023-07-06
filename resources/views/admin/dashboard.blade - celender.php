@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')

	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}"> 
	
	
	<!-- Core JS files -->
	<script src="{{asset('celender/main/jquery.min.js')}}"></script>
	<script src="{{asset('celender/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('celender/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- 
		Theme JS files 
	-->
	<script src="{{asset('celender/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('celender/ui/fullcalendar/fullcalendar.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('celender/demo_pages/fullcalendar_styling.js')}}"></script>

<style>
table {
  border-collapse: collapse;
  width: 100%; 
}

th, td {
  text-align: left;
  padding: 8px;
  
}

tr:nth-child(even) {background-color: #f9f9f9;}

.c_btn
{
	font-size:10px;
	margin-bottom: 2px;
	text-align: left;
	padding: 0px 2px 0px 2px;
}

.today
{
    background-color: #5cb85c;
    padding: 2px 10px 2px 10px;
    color: white;
    font-size: 12px;
    margin-left: 10px;
}

</style>	
	
@endsection

@section('content')


	
	<div class="content-area py-1">
		<div class="container-fluid">
		
		<div class="container">
		  <div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading bg-success">
					<div style="float:left;">Celender</div>
					<div style="float:right;">2020</div>
					<div style="clear:both;"></div>
				</div>
				<div class="panel-heading">
					<div style="float:left;"><h5><strong>Janaury (2020)</strong></h5></div>
					<div style="float:right;">
					<button type="button" class="btn btn-success btn-sm"><</button>
					<button type="button" class="btn btn-success btn-sm">></button>
					</div>
					<div style="clear:both;"></div>
				</div>
			  <div class="panel-body">
				<table class="table table-bordered">
				  <tr>
					<th id="mon" width="14%" class="text-center">Monday</th>
					<th id="tue" width="14%" class="text-center">Tuesday</th>
					<th id="wed" width="14%" class="text-center">Wednesday</th>
					<th id="thu" width="14%" class="text-center">Thursday</th>
					<th id="fri" width="14%" class="text-center">Friday</th>
					<th id="sat" width="14%" class="text-center">Saturday</th>
					<th id="sun" width="14%" class="text-center">Sunday</th>
				  </tr>
				  <tr>
					<td width="14%" height="80px">30</td>
					<td width="14%">31</td>
					<td id="1" width="14%">1<br>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:00 AM</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM 
							<span class="alert text-white bg-danger p-0 ml-1">D T</span>
						</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM</button>
						<button type="button" class="btn btn-success btn-sm col-md-12 c_btn">9:10 AM</button>
					</td>
					
					<td id="2" width="14%">2</td>
					<td id="3" width="14%">3<br>
						<button type="button" class="btn btn-default btn-sm col-md-12 c_btn">Default</button>
						<button type="button" class="btn btn-primary btn-sm col-md-12 c_btn">Primary</button>
					</td>
					<td id="4" width="14%">4</td>
					<td id="5" width="14%">5</td>
				  </tr>
				  <tr>
					<td id="6" width="14%" height="80px">6</td>
					<td id="7" width="14%">7</td>
					<td id="8" width="14%">8</td>
					<td id="9" width="14%">9</td>
					<td id="10" width="14%">10</td>
					<td id="11" width="14%">11</td>
					<td id="12" width="14%">12</td>
				  </tr>
				  <tr>
					<td width="14%" height="80px">13<span class="today"><i>Today</i></span>
					<br><button type="button" class="btn btn-warning btn-sm col-md-12 c_btn">9:30 AM</button>
					</td>
					<td width="14%">14</td>
					<td width="14%">15<br><button type="button" class="btn btn-warning btn-sm col-md-12 c_btn">9:30 AM</button></td>
					<td width="14%">16</td>
					<td width="14%">17</td>
					<td width="14%">18<br>
						<button type="button" class="btn btn-danger btn-sm col-md-12 c_btn">10:30 AM</button>
						<button type="button" class="btn btn-danger btn-sm col-md-12 c_btn">11:30 AM</button>
					</td>
					<td width="14%">19</td>
				  </tr>
				  <tr>
					<td width="14%" height="80px">20</td>
					<td width="14%">21</td>
					<td width="14%">22</td>
					<td width="14%">23</td>
					<td width="14%">24</td>
					<td width="14%">25</td>
					<td width="14%">26</td>
				  </tr>
				  <tr>
					<td width="14%" height="80px">27</td>
					<td width="14%">28</td>
					<td width="14%">29</td>
					<td width="14%">30</td>
					<td width="14%">31</td>
					<td width="14%">1</td>
					<td width="14%">2</td>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
		
			<!-- Content area -->
			<div class="content">
			<div class="box box-block bg-white">
			<div class="card">
			<div class="card-title"></div>
			<div class="card-body">
				
			</div>
			
			<hr>
			
				@include('admin.dashboard.count') 

				<!-- Event colors -->
				<div class="card">
				
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Job Schedule</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>
					<div class="p-5">
						<div id="calender"></div>	
					</div>	
					<!--<div class="card-body p-5"><div class="fullcalendar-event-colors"></div></div> -->
				</div>
				<!-- /event colors -->
				
				

			</div>
			
			
			
			
		</div>	
	</div>		

	<script>
		$(function() 
		{
			$('#calender').fullCalendar({
				eventSources: [
					{
						url: '{{ route('admin.getAllEvents') }}', // use the `url` property
						color: 'pink',    // an option!
						textColor: 'black'  // an option!
					}
				],
				editable: true,
				eventDurationEditable:false,
				eventRender:function(eventObj, $el) 
				{
					let title = $el.find( '.fc-title' );
					title.html( title.text() );
				},
				eventDrop: function(data, duration)
				{
					let id = data.id;
					let date = data.start.format("YYYY-MM-DD");
					$.ajax({
						url: "/admin/update_date/"+id+"/"+date,
						success: function(result){
							console.log(result);
						}
					});
				},
				eventClick: function(calEvent, jsEvent, view) 
				{
					let url = `/admin/${calEvent.endpoint}/${calEvent.id}`;
					window.open(url, '_blank');
				}
			});
		});
	</script>
@endsection
