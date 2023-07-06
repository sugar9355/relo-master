@extends('admin.layout.base')

@section('title', 'Update Opportunity ')

@section('content')

	<div class="card">
		<div class="card-body">

				<h4 class="m-0">Update Opportunity <a href="{{ route('admin.opportunity.index') }}" class="btn btn-outline-dark pull-right"><i class="fa fa-angle-left"></i> Back</a></h4>
				<hr>
				

				<form action="{{route('admin.opportunity.update', $Opportunity->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					
					<div class="form-row">
					<div class="form-group col-md-6">
                        <label for="name" class="form-label">@lang('admin.name')</label>                        
                            <input class="form-control" type="text" value="{{ $Opportunity->name }}" name="name" required id="name"
                                   placeholder="Name">
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="level" class="form-label">Employee Role</label>                        
                            <select class="form-control" name="role" id="">
								<option value="captain" @if($Opportunity->role == "captain") selected @endif >Captain</option>
								<option value="helper" @if($Opportunity->role == "helper") selected @endif>Helper</option>
								<option value="technician" @if($Opportunity->role == "technician") selected @endif>Technician</option>
							</select>
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="hourly_rate" class="form-label">Hourly Rate</label>                        
                            <input class="form-control" type="text" value="{{ $Opportunity->hourly_rate }}" name="hourly_rate" required id="hourly_rate"
                                   placeholder="hourly_rate">
                    </div>
					
					<div class="form-group col-md-6">
                        <label for="hourly_rate" class="form-label">Validaity</label>                        
                            <input class="form-control" type="text" value="{{ $Opportunity->validaity }}" name="validaity" required id="validaity"
                                   placeholder="validaity">
                    </div>
					
					<div class="form-group col-md-12">
                        <label for="description" class="form-label">Description</label>                        
                           <textarea class="form-control" rows="3" type="text" name="description" id="description" placeholder="Description">{{ $Opportunity->description }}</textarea>
                    </div>
                    </div>

                    <hr>
					
					<div class="form-group">
						
							<button type="submit" class="btn btn-primary">Update Opportunity</button>
							<a href="{{route('admin.opportunity.index')}}" class="btn btn-outline-dark">Cancel</a>
					</div>
				</form>
	
		</div>
	</div>

@endsection
