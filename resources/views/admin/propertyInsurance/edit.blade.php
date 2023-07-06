@extends('admin.layout.base')

@section('title', 'Update propertyInsurance ')

@section('content')

    <div class="card">
        <div class="card-body">
            
                <a href="{{ route('admin.propertyInsurance.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')
                </a>

                <h5 style="margin-bottom: 2em;">Update Property Insurance</h5>

                <form class="form-horizontal" action="{{route('admin.propertyInsurance.update', $PropertyInsurance->id )}}" method="POST" enctype="multipart/form-data"
                      role="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
					
					<div class="card-body">

					<div class="row mb-3">
						<div class="col-md-6">
							<label>Property Name</label>	
							
							<input type="text" name="name" class="form-control" value="{{ $PropertyInsurance->name }}" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
								<label>dollar Value</label>
								<input type="number" name="value" class="form-control" value="{{ $PropertyInsurance->value }}" placeholder="$">	
						</div>
					</div>


					</div>
                   
                </form>
            </div>
        
    </div>

@endsection
