@extends('admin.layout.base')

@section('title', 'Add Level ')

@section('content')

    <div class="card">
        <div class="card-body">
            
                <a href="{{ route('admin.level.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> @lang('admin.back')</a>

                <h5 style="margin-bottom: 2em;">Add Level</h5>

                <form class="form-horizontal" action="{{route('admin.level.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name"
                                   placeholder="Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bonus" class="col-md-12 col-form-label">Bonus Amount</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" required name="bonus" value="{{old('bonus')}}" id="bonus" placeholder="Bonus Amount">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="bonus" class="col-md-12 col-form-label">Referal Bonus Amount</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="ref_bonus" id="ref_bonus" value="{{old('ref_bonus')}}" placeholder="Referal Bonus Amount">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label for="level" class="col-md-12 col-form-label">Level</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="level" id="level" value="{{ old('level') }}" placeholder="Level">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="hours" class="col-md-12 col-form-label">Hours Required </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="hours" id="hours" value="{{ old('hours') }}" placeholder="hours">
                        </div>
                    </div>
					
					<div id="div_level" class="form-group">
                        <label for="level" class="col-md-12 col-form-label">Designation</label>
                        <div class="col-md-10">
                            <div class="col-md-2">
							<input type="checkbox" name="role_A" value="4"  ><strong> Captain</strong>
							</div>
							<div class="col-md-2">
								<input type="checkbox" name="role_B" value="5"  ><strong> Helper</strong>
							</div>
							<div class="col-md-2">
								<input type="checkbox" name="role_C" value="6"  ><strong> Technician</strong>
							</div>
                        </div>
                    </div>
					
					<div class="form-group">
					<hr>
						<label for="hours" class="col-md-12 col-form-label">Badges Required For Level</label>
					</div>
					
					<div class="form-group">
						<div class="col-md-12">
						@foreach($designation_type as $key => $type)
						
						<h4>{{$type->badge_type_name}}</h4>
							<table class="table table-striped table-bordered dataTable no-footer dtr-inline">
								<tr><th width="5%">No</th><th width="5%">Select Badge</th><th width="15%">Badge</th><th width="40%">Description</th><th width="10%">Badge limit</th></tr>
								@foreach($designation as $k => $val)
								@if($val->badge_type_id == $type->badge_type_id)
									<tr>
										<td>{{$k+1}}</td>
										<td><input type="checkbox" name="lvl_factor[{{$val->factor_id}}][check]" @if($val->lf_factor_id > 0) checked @endif value="1"></td>
										<td>{{$val->factor_name}}</td>
										<td>{{$val->factor_description}}</td>
										<td>
										@if($val->df_factor_value > 0)
											{{$val->df_factor_value}}
										@else
											<font color="red">N/A</font>
										@endif
										</td>
										
									</tr>
								@endif	
								@endforeach
							</table>
						@endforeach	
						</div>
					</div>

                    
                    <div class="form-group">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">Add Level</button>
                            <a href="{{route('admin.level.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
                        </div>
                    </div>
                </form>
			
        </div>
    </div>

@endsection
