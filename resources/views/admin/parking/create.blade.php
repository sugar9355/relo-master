@extends('admin.layout.base')

@section('title', 'Add Parking ')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.parking.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Add Parking</h5>

				<form class="form-horizontal" action="{{route('admin.parking.store')}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}

					<div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Min</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ old('time') }}" name="time" required id="time"
                                   placeholder="5">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Med</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ old('time_med') }}" name="time_med" required id="time_med"
                                   placeholder="7">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Max</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number"  value="{{ old('time_max') }}" name="time_max" required id="time_max"
                                   placeholder="10">
                        </div>

                    </div>
					<div class="form-group">
						<label for="flag" class="col-md-12 col-form-label">Ramp Type</label>
						<div class="col-md-10">
							<select name="ramp" class="form-control">
								<option value="Ramp">Ramp</option>
								<option value="No Ramp">No Ramp</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">Parking permit </label>
						<div class="col-md-10">
						<input class="form-control" type="number"  value="{{ old('ptime') }}" name="ptime" required id="time"
                                   placeholder="Min"> <br/>
								   <input class="form-control" type="number"  value="{{ old('ptimemed') }}" name="ptimemed" required id="time"
                                   placeholder="Med"> <br/>
								   <input class="form-control" type="number"  value="{{ old('ptimemax') }}" name="ptimemax" required id="time"
                                   placeholder="Max">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">Metered parking </label>
						<div class="col-md-10">
						<input class="form-control" type="number"  value="{{ old('mtime') }}" name="mtime" required id="mtime"
                                   placeholder="Min"> <br/>
								   <input class="form-control" type="number"  value="{{ old('mtimemed') }}" name="mtimemed" required id="time"
                                   placeholder="Med"> <br/>
								   <input class="form-control" type="number"  value="{{ old('mtimemax') }}" name="mtimemax" required id="time"
                                   placeholder="Max">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">Commercial parking </label>
						<div class="col-md-10">
						<input class="form-control" type="number"  value="{{ old('ctime') }}" name="ctime" required id="time"
                                   placeholder="Min"> <br/>
								   <input class="form-control" type="number"  value="{{ old('ctimemed') }}" name="ctimemed" required id="time"
                                   placeholder="Med"> <br/>
								   <input class="form-control" type="number"  value="{{ old('ctimemax') }}" name="ctimemax" required id="time"
                                   placeholder="Max">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">Easy street parking </label>
						<div class="col-md-10">
						<input class="form-control" type="number"  value="{{ old('etime') }}" name="etime" required id="time"
                                   placeholder="Min"> <br/>
								   <input class="form-control" type="number"  value="{{ old('etimemed') }}" name="etimemed" required id="time"
                                   placeholder="Med"> <br/>
								   <input class="form-control" type="number"  value="{{ old('etimemax') }}" name="etimemax" required id="time"
                                   placeholder="Max">
						</div>
					</div>
					<div class="form-group">
						<label for="zip_code" class="col-md-12 col-form-label">Home driveway </label>
						<div class="col-md-10">
						<input class="form-control" type="number"  value="{{ old('dtime') }}" name="dtime" required id="time"
                                   placeholder="Min"> <br/>
								   <input class="form-control" type="number"  value="{{ old('dtimemed') }}" name="dtimemed" required id="time"
                                   placeholder="Med"> <br/>
								   <input class="form-control" type="number"  value="{{ old('dtimemax') }}" name="dtimemax" required id="time"
                                   placeholder="Max">
						</div>
					</div>
					<div class="form-group">
						<label for="zip_code" class="col-md-12 col-form-label">Description</label>
						<div class="col-md-10">
							<textarea class="form-control" type="text"  name="decription"  >{{ old('decription') }}</textarea>
						</div>
					</div>
					<!--div class="form-group row">
						<label for="flag" class="col-md-12 col-form-label">@lang('admin.flag')</label>
						<div class="col-md-10">
							<select name="flag" class="form-control">
								<option value="Flag">Flag</option>
								<option value="Un-Flag">Un Flag</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{ (old('color')) ? old('color') : '#000000'}}" name="color" required id="color" placeholder="Color">
						</div>
						<div class="col-md-2">
							<div id="colorpicker"></div>
						</div>
					</div-->
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">Add Parking</button>
							<a href="{{route('admin.parking.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
