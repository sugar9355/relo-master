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
</div>
<div class="row mt-3">
  <div class="col-6 text-left">
	@if (isset($charges['additional_charges']))
	<strong>${{number_format(($charges['total_charges'] + $charges['additional_charges']) * $accuracy_min, 2)}}</strong>
	@else
	<strong>${{number_format($charges['total_charges'] * $accuracy_min, 2)}}</strong>
	@endif
  </div>
  <div class="col-6 text-right">
	@if (isset($charges['additional_charges']))
	<strong>${{number_format(($charges['total_charges'] + $charges['additional_charges']) * $accuracy_max, 2)}}</strong>
	@else
	<strong>${{number_format($charges['total_charges'] * $accuracy_max, 2)}}</strong>
	@endif
  </div>
</div>
</div>
@php 
@endphp

	<div class="card mt-3" id="insurancebox">
		<div id="accordion-default" class="card">
		<div class="card-header">
			@if (isset($charges['additional_charges']))
				<h6 class="card-title mb-0"><a data-toggle="collapse" class="text-dark" href="#accordion-item-default1"> <h3 class="m-0"><i class="fas fa-file-invoice-dollar fa-large mr-2"></i> Charges <span class="float-right">${{number_format($charges['total_charges'] + $charges['additional_charges'], 2)}}</span></h3></a></h6>
			@else
				<h6 class="card-title mb-0"><a data-toggle="collapse" class="text-dark" href="#accordion-item-default1"> <h3 class="m-0"><i class="fas fa-file-invoice-dollar fa-large mr-2"></i> Charges <span class="float-right">${{number_format($charges['total_charges'], 2)}}</span></h3></a></h6>
			@endif
		</div>

		<div id="accordion-item-default1" class="collapse" data-parent="#accordion-default">
		<div class="card-body">
		<div id="accordion-crew" class="card mb-1">
		<div class="card-header pb-0">
			<a data-toggle="collapse" class="text-dark" href="#accordion-item-crew"><p class="font-weight-bold">Crew Charges <span class="float-right">${{number_format($charges['total_crew_charge'], 2)}}</span></p></a>
		</div>
		<div id="accordion-item-crew" class="collapse" data-parent="#accordion-crew">
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Total Crew Charges <span class="float-right">${{number_format($charges['total_crew_rate'] * $charges['total_crew_time'], 2)}}</span></p>
			</div>
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Long Walk<span class="float-right">${{number_format($charges['walk_charge'], 2)}}</span></p>
			</div>
		</div>

		</div>		

		<div id="accordion-mobile" class="card mb-1">
		<div class="card-header pb-0">
		@if (isset($charges['reservation_fee']))
		<a data-toggle="collapse" class="text-dark" href="#accordion-item-mobile"><p class="font-weight-bold">Mobilization Charges <span class="float-right">${{number_format($charges['mob_charges'] + $charges['reservation_fee'], 2)}}</span></p></a>
		@else
		<a data-toggle="collapse" class="text-dark" href="#accordion-item-mobile"><p class="font-weight-bold">Mobilization Charges <span class="float-right">${{number_format($charges['mob_charges'], 2)}}</span></p></a>
		@endif
		</div>
		<div id="accordion-item-mobile" class="collapse" data-parent="#accordion-mobile">
			<div class="card-body pb-0">
				<p class="font-weight-bold pb-2">Total Mobilization Charges <span class="float-right">${{number_format($charges['mob_charges'], 2)}}</span></p>

				@if (isset($charges['reservation_fee']))
				<p class="font-weight-bold pb-2">Reservation Fee <span class="float-right">${{number_format($charges['reservation_fee'], 2)}}</span></p>
				@endif
				
			</div>
		</div>

		</div>	
		
		<div id="accordion-insurance" class="card">
			<div class="card-header pb-0">
				<a data-toggle="collapse" class="text-dark" href="#accordion-item-insurance"><p class="font-weight-bold">Insurance Charges <span class="float-right">${{$booking->insurance}}</span></p></a>
			</div>
		</div>	

		@if (isset($charges['additional_charges']))
		<div id="accordion-add-charges" class="card">
			<div class="card-header pb-0">
				<a data-toggle="collapse" class="text-dark" href="#accordion-item-add-charges"><p class="font-weight-bold">Additional Charges <span class="float-right">${{$charges['additional_charges']}}</span></p></a>
			</div>
		</div>	
		@endif
		
		</div>
		</div>

		</div>
	</div>