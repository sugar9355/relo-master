<div class="card hvr-shadow w-100 card-body">
<h5 class="border-bottom pb-2">Pricing</h5>

<div class="row mt-3">
  <div class="col-6 text-left">
	<strong>Low</strong>
  </div>
  <div class="col-6 text-right">
	<strong>High</strong>
  </div>
</div>
<div class="progress my-2">
  <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
  <div class="progress-bar bg-warning" role="progressbar" style="width: 33%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
  <div class="progress-bar bg-danger" role="progressbar" style="width: 34%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
  <!-- <span class="pricing" style="left: 45%">Est. Price ${{round($booking->total_rate)}}</span> -->
</div>
<div class="row mt-3">
  <div class="col-6 text-left">
	<strong>${{round($booking->min)}}</strong>
  </div>
  <div class="col-6 text-right">
	<strong>${{round($booking->max)}}</strong>
  </div>
</div>
</div>
@php 
$tot_mob_crew_rate = $charges['tot_mob_crew_rate'];
$tot_crew_hourly_rate  = $charges['tot_crew_hourly_rate']; 
$crew_hourly_rate  = $charges['crew_hourly_rate']; 
$mileage_rate_A_B  = $charges['mileage_rate_A_B']; 
$mileage_rate_H_A  = $charges['mileage_rate_H_A']; 
$mileage_rate_B_H  = $charges['mileage_rate_B_H']; 
@endphp

	<div class="card mt-3" id="insurancebox">
		<div id="accordion-default" class="card">
		<div class="card-header">
			<h6 class="card-title mb-0"><a data-toggle="collapse" class="text-dark" href="#accordion-item-default1"> <h3 class="m-0"><i class="fas fa-file-invoice-dollar fa-large mr-2"></i> Charges <span class="float-right">${{substr($tot_mob_crew_rate+$tot_crew_hourly_rate+$mileage_rate_A_B+$mileage_rate_H_A+$mileage_rate_B_H,0,5)}}</span></h3></a></h6>
		</div>

		<div id="accordion-item-default1" class="collapse" data-parent="#accordion-default">
		<div class="card-body">
		<div id="accordion-crew" class="card mb-1">
		<div class="card-header pb-0">
			<a data-toggle="collapse" class="text-dark" href="#accordion-item-crew"><p class="font-weight-bold">Crew Charges <span class="float-right">${{substr($tot_crew_hourly_rate+$mileage_rate_A_B,0,5)}}</span></p></a>
		</div>
		<div id="accordion-item-crew" class="collapse" data-parent="#accordion-crew">
		@foreach($crew_hourly_rate as $k => $rate)
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Crew {{$k+1}}<span class="float-right">${{substr($rate,0,4)}}</span></p>
			</div>
		@endforeach	
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Mileage<span class="float-right">${{substr($mileage_rate_A_B,0,4)}}</span></p>
			</div>
		</div>

		</div>		

		<div id="accordion-mobile" class="card mb-1">
		<div class="card-header pb-0">
			<a data-toggle="collapse" class="text-dark" href="#accordion-item-mobile"><p class="font-weight-bold">Mobilization Charges <span class="float-right">${{substr($mileage_rate_H_A + $tot_mob_crew_rate + $mileage_rate_B_H,0,4)}}</span></p></a>
		</div>
		<div id="accordion-item-mobile" class="collapse" data-parent="#accordion-mobile">
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Hub to A <span class="float-right">${{substr($mileage_rate_H_A,0,4)}}</span></p>
				
				<p class="font-weight-bold pb-2">A to B <span class="float-right">${{substr($tot_mob_crew_rate,0,5)}}</span></p>
				
				<p class="font-weight-bold pb-2">B to Hub <span class="float-right">${{substr($mileage_rate_B_H,0,5)}}</span></p>
			</div>
		</div>

		</div>	
		
		<div id="accordion-insurance" class="card">
			<div class="card-header pb-0">
				<a data-toggle="collapse" class="text-dark" href="#accordion-item-insurance"><p class="font-weight-bold">Insurance Charges <span class="float-right">${{$booking->insurance}}</span></p></a>
			</div>
		</div>	

		
		</div>
		</div>

		</div>
	</div>