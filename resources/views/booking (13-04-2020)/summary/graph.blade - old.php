<script>
		
	var data;
	var options;
	let chart;
	var stndDev = {{$booking->max - $booking->total_rate}};
	var mean = {{$booking->total_rate}};
	let xMin = {{$booking->min - 1.5}};
	let xMax = {{$booking->max + 1.5}};
	let xLeft = {{$booking->min}};
	let xRight = {{$booking->max}};

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

	
	<div class="card card-body border border-warning">

            <div id="chart_div"></div>
            <p class="lead text-center font-weight-bold">Price Estimation Graph</p>
			Total Rate: {{round($booking->total_rate)}} 
			Range : {{round($booking->min)}} - {{round($booking->max)}}

    </div>
	
	<div class="card mt-3" id="insurancebox">
		<div id="accordion-default" class="card">
		<div class="card-header bg-dark text-white">
			<h6 class="card-title mb-0"><a data-toggle="collapse" class="text-white" href="#accordion-item-default1"> <h3 class="m-0"><i class="fas fa-file-invoice-dollar fa-large mr-2"></i> Charges <span class="float-right"></span></h3></a></h6>
		</div>

		<div id="accordion-item-default1" class="collapse" data-parent="#accordion-default">
		<div class="card-body">
		<div id="accordion-crew" class="card mb-1">
		<div class="card-header pb-0">
			<a data-toggle="collapse" class="text-dark" href="#accordion-item-crew"><p class="font-weight-bold">Crew Charges <span class="float-right"></span></p></a>
		</div>
		<div id="accordion-item-crew" class="collapse" data-parent="#accordion-crew">
		
			<div class="card-body pb-0">
				
			</div>
		</div>

		</div>		

		<div id="accordion-mobile" class="card mb-1">
		<div class="card-header pb-0">
			<a data-toggle="collapse" class="text-dark" href="#accordion-item-mobile"><p class="font-weight-bold">Mobilization Charges <span class="float-right"></span></p></a>
		</div>
		<div id="accordion-item-mobile" class="collapse" data-parent="#accordion-mobile">
			<div class="card-body pb-0">
				
			</div>
		</div>

		</div>	
		
				
		</div>
		</div>

		</div>
	</div>

