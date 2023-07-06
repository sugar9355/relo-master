@extends('admin.layout.base')

@section('title', 'Add Opportunity ')

@section('content')

    <div class="card">
        <div class="card-body">

                <h4 class="m-0">Add Opportunity <a href="{{ route('admin.opportunity.index') }}" class="btn btn-outline-dark float-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a></h4>
                <hr>

                <form action="{{route('admin.opportunity.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}

                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class="form-label">@lang('admin.name')</label>
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name"
                                   placeholder="Name">
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="level" class="form-label">Employee Role</label>
                        
                            <select class="form-control" name="role" id="">
								<option value="captain">Captain</option>
								<option value="helper">Helper</option>
								<option value="technician">Technician</option>
							</select>
                       
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="hourly_rate" class="form-label">Hourly Rate</label>
                        
                            <input class="form-control" type="text" value="{{ old('hourly_rate') }}" name="hourly_rate" required id="hourly_rate"
                                   placeholder="hourly_rate">
                       
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="hourly_rate" class="form-label">Validaity</label>
                        
                            <input class="form-control" type="text" value="{{ old('validaity') }}" name="validaity" required id="validaity"
                                   placeholder="validaity">
                      
                    </div>
					
					<div class="form-group col-md-12">
                        <label for="description" class="form-label">Description</label>
                        
                           <textarea class="form-control" rows="3" type="text" name="description" id="description" value="{{ old('description') }}" placeholder="Description"></textarea>
                
                    </div>

                    </div>
                    <hr>
                    <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Opportunity</button>
                            <a href="{{route('admin.opportunity.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                        </div>
                </form>
            
        </div>
    </div>

@endsection
