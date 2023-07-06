@extends('admin.layout.base')

@section('title', 'Update Notification Schedule ')

@section('content')
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			/* display: none; <- Crashes Chrome on hover */
			-webkit-appearance: none;
			margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
		}

		input[type=number] {
			-moz-appearance:textfield; /* Firefox */
		}
		input[type=checkbox] {
			margin: 4px 5px 0 !important;
		}
	</style>
	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.notification_schedule.index') }}"
				   class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Update Notification Schedule</h5>

				<form class="form-horizontal" action="{{route('admin.notification_schedule.update', $notificationSchedules->id)}}"
					  method="POST" role="form">
					{{ method_field('PUT') }}
					{{csrf_field()}}
					<div class="form-group">
						<label for="days" class="col-md-12 col-form-label">Days</label>
						<div class="col-md-10">
							<input class="form-control" type="number" value="{{ $notificationSchedules->days }}"
								   name="days" id="days" placeholder="5">
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-md-12 col-form-label">Status</label>
						<div class="col-md-10">
							<select name="status" id="status" class="form-control">
								<option value="Pending" {{ ($notificationSchedules->status == "Pending") ? "selected" : null }}>Pending</option>
								<option value="SAVE" {{ ($notificationSchedules->status == "SAVE") ? "selected" : null }}>Save Later</option>
								<option value="UNASSIGNED" {{ ($notificationSchedules->status == "UNASSIGNED") ? "selected" : null }}>Un Assigned</option>
								<option value="ASSIGNED" {{ ($notificationSchedules->status == "ASSIGNED") ? "selected" : null }}>Assigned</option>
								<option value="COMPLETED" {{ ($notificationSchedules->status == "COMPLETED")  ? "selected" : null}}>Completed</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="message" class="col-md-12 col-form-label">Message</label>
						<div class="col-md-10">
							<textarea name="message" id="message" cols="30" rows="10" style="resize: none;" placeholder="Message Here!"
									  class="form-control">{{ $notificationSchedules->message }}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-5">
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="sms" id="sms" value="1"
										   {{ ($notificationSchedules->sms == 1) ? 'checked' : null }}>SMS
								</label>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="email" id="email" value="1"
											{{ ($notificationSchedules->email == 1) ? 'checked' : null }}>Email
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">Update Notification Schedule</button>
							<a href="{{ route('admin.notification_schedule.index') }}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('input[type=number]').keypress(function (e) {
				let txt = String.fromCharCode(e.which);
				if (!txt.match(/[0-9]/)) {
					return false;
				}
			});
		});
	</script>


@endsection
