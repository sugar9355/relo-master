@extends('user.layout.app')

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">  

@section('content')

  <script>
    

var data;
var options;
let chart;
var stndDev = 1;
var mean = 0;
let xMin = -4.1;
let xMax = 4.1;
let xLeft = -2;
let xRight = 2;

google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(prepareChart);

function prepareChart() {
  data = new google.visualization.DataTable();
  setChartOptions();
  addColumns();
  addData();
  drawChart();
}
function setChartOptions() {
  options = { legend: "none" };
  options.hAxis = {};
  options.hAxis.minorGridlines = {};
  options.hAxis.minorGridlines.count = 5;
  return options;
}
function addColumns() {
  data.addColumn("number", "X Value");
  data.addColumn("number", "Y Value");
  data.addColumn({ type: "boolean", role: "scope" });
  data.addColumn({ type: "string", role: "style" });
}
function addData() {
  data.addRows(createArray(xMin, xMax, xLeft, xRight, mean, stndDev));
}
function createArray(xMin, xMax, xLeft, xRight, mean, stndDev) {
  let chartData = new Array([]);
  let index = 0;
  for (var i = xMin; i <= xMax; i += 0.1) {
    chartData[index] = new Array(4);
    chartData[index][0] = i;
    chartData[index][1] = jStat.normal.pdf(i, mean, stndDev);

    if (i < xLeft || i > xRight) {
      chartData[index][2] = false;
    }
    chartData[index][3] =
      "opacity: 1; + color: #ffc107; + stroke-color: black; ";

    index++;
  }
  return chartData;
}
function drawChart() {
  chart = new google.visualization.AreaChart(
    document.getElementById("chart_div")
  );
  chart.draw(data, options);
}

  </script>
    
  <section class="content" id="summary">
    <div class="container my-5">
    <h2 class="pb-2 border-bottom mb-3">Summary</h2> 
      <div class="row">
        <div class="col-md-7">
          <div class="card card-body bg-warning" id="locations">
            
			@foreach($booking_location as $k => $location)
            <div class="media">
				
			  
              <div class="media-body">
				@if($k == 0)
					<p><small>Pickup Location</small><br>
				@else	
					<p><small>Dropoff Location</small><br>
				@endif
				@if($k == 0)
					<i class="icon-home2 text-danger icon-2x mb-1 col-md-1"></i>
					@else	
					<i class="icon-home5 text-danger icon-2x mb-1 col-md-1"></i>
					@endif
                   <span class="bg-white rounded-bottom py-1 px-2 shadow-sm mt-1 d-inline-block">{{$location->location}}</span>
                </p>                
              </div>
            </div>
 
			@endforeach
          </div>

		  
		  @include('booking.summary.inventory')
 
        <div class="card card-body mt-4">          
          <h3 class="m-0 border-bottom pb-3 mb-3"><i class="fas fa-people-carry fa-large mr-2"></i> Crew Required</h3>

          <div class="bg-warning p-2 rounded mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheckDisabled1" checked >
              <label class="custom-control-label text-white" for="customCheck1">2 Man Recommended</label>
            </div>
          </div>
          <div class="bg-light p-2 rounded mb-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck1" >
              <label class="custom-control-label" for="customCheck1">4 Man <small>(Saves Time & Add Extra Cost)</small></label>
            </div>
          </div>
          <div class="bg-light p-2 rounded mb-2">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1" >
            <label class="custom-control-label" for="customCheckDisabled1">1 Man <small>(Save $50)</small></label>
          </div>
        </div>
        </div>

        </div>

        <div class="col-md-5">
          <div class="card card-body border border-warning">

            <div id="chart_div"></div>
            <p class="lead text-center font-weight-bold">Price Estimation Graph</p>

          </div>
          

          <div class="card mt-3" id="insurancebox">
            <div class="card-header bg-dark text-white">
              <h3 class="m-0"><i class="fas fa-file-invoice-dollar fa-large mr-2"></i> Charges</h3>
            </div>
            <div class="card-body">
              <p class="font-weight-bold pb-2 border-bottom">Mobilization Charges <i class="fas fa-info-circle text-muted"></i> <span class="float-right">$30 - $60</span></p>
              <p class="font-weight-bold pb-2 border-bottom">Crew Charges <i class="fas fa-info-circle text-muted"></i> <span class="float-right">$50 - $100</span></p>
            </div>
          </div>
  
		@include('booking.summary.insurance')
  
		@include('booking.summary.date_time')
          
        </div>

      </div>
	  
	  <div class="col-md-12 text-center">
		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

			{{ csrf_field() }}

			<hr>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal animated slideInLeft" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
				<button name="btn_submit" type="submit" value="checkout" class="btn btn-warning m-auto hvr-icon-wobble-horizontal px-5 animated slideInRight">Finish <i class="far fa-smile-wink hvr-icon"></i></button>
			</div>
		</form>
    </div>

  </section>

@endsection
