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
						<a class="lead btn h-100 btn-success btn-block py-3 hvr-grow hvr-icon-bob shadow" id="sel-vtype">
							<i class="fas fa-check fa-2x pb-2 hvr-icon"></i>
							<br>Would you like to upgrade?</a>
					</div>
					<div class="col m-auto">
						<a class="lead btn h-100 btn-danger btn-block py-3 hvr-grow hvr-icon-bob" id="cancel-vtype" data-dismiss="modal">
							<i class="fas fa-times fa-2x pb-2 hvr-icon"></i>
							<br>Keep the same truck and remove items</a>
					</div>
				</div>

				<hr>

				<div id="vehicle-types" style="display: none">
					<h4 class="mt-3">What Would You Like To Add?</h4>

					<div class="row mt-4">

						@foreach ($v_types as $t)
						<div class="col-md-3">
							<div class="card">
								<div class="card-header">
									{{$t->name}}
								</div>
								<div class="card-body px-3">
									<h3 class="mb-2">${{$t->add_charges}}</h3>
									Additional Charges
									Volume: {{$t->volume}}
									<button type="button" name="" data-name="{{$t->name}}"
										class="btn btn-outline-dark btn-sm btn-block mt-3 vt-select">Select</button>
								</div>

							</div>
						</div>
						@endforeach

					</div>

					<hr>
					<form action="/change_vehicle/{{$booking->booking_id}}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="vtype_name" id="vtype_name" required />
						<button class="btn btn-success btn-lg" type="submit">Proceed <i class="fas fa-chevron-right hvr-icon"></i></button>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<script>
	$('#sel-vtype').click(function() {
		$('#vehicle-types').show()
	})

	$('#cancel-vtype').click(function() {
		$('#vehicle-types').hide()
	})

	$('.vt-select').click(function() {
		var type_name = $(this).data('name')
		$.ajax({
			url: "/check_vehicle/" + type_name,
			type: 'GET',
			success: function(data) {
				if (data == 0) {
					alert("No available vehicle for that type. Please select another one.")
				} else {
					$('#vtype_name').val(type_name)
					console.log($('#vtype_name').val())
				}
			}
		})
	})
</script>