<div id="newtruck" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body pt-5 text-center">
				<i class="fas fa-exclamation fa-4x mb-3 text-danger"></i>

				<h3 class="m-0 text-danger mb-3">Your designated truck has exceeded its capacity</h3>
				<button type="button" class="close d-none" data-dismiss="modal">&times;</button>

					<div class="row mt-5 px-md-3 text-white">
						<div class="col m-auto">
							<a class="lead btn h-100 btn-success btn-block py-3 hvr-grow hvr-icon-bob shadow">
								<i class="fas fa-check fa-2x pb-2 hvr-icon"></i>
								<br>Would you like to upgrade?</a>
						</div>
						<div class="col m-auto">
							<a class="lead btn h-100 btn-danger btn-block py-3 hvr-grow hvr-icon-bob">
								<i class="fas fa-times fa-2x pb-2 hvr-icon"></i>
								<br>Keep the same truck and remove items</a>
						</div>
					</div>

					<hr>

					<h4 class="mt-3">What Would You Like To Add?</h4>
					
					<div class="row mt-4">
						@foreach($available_trucks as $truck)
						<div class="col-md-3">
							<div class="card">
								<div class="card-header">
									{{$truck->name}}
								</div>
								<div class="card-body px-3">
									<h3 class="mb-2">$50</h3>
									Additional Charges
									volume:{{$truck->volume}} cm3
									<form action="/booking/{{ $booking->booking_id }}" method="post" enctype="multipart/form-data">
										{{csrf_field()}}					
										<button type="submit" name="btn_new_truck" value ="{{$truck->pk_truck_id}},{{$truck->name}},{{$truck->volume}}" class="btn btn-outline-dark btn-sm btn-block mt-3">Select</button>
									</form>
								</div>
								
							</div>
						</div>
						@endforeach
					
					</div>
					
					<hr>
					<button class="btn btn-success btn-lg" data-dismiss="modal">Proceed <i class="fas fa-chevron-right hvr-icon"></i></button>

			</div>
		</div>
	</div>
</div>