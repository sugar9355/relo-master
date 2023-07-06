@extends('user.layout.app')
@section('content')

    <div class="container my-5">
    
       <h4 class="text-center animated fadeIn delay-0-2s"><i class="fas fa-people-carry animated bounceIn delay-0-2s"></i> SERVICE TYPE</h4>
        <hr>
        <div class="row">
            @foreach($services as $service)
                <div class="col-6 mt-3">
                    <div class="card card-body rounded text-center hvr-shadow d-block animated bounceIn delay-0-2s">                        
                        
                            <h3 class="m-0" data-val="{{ $service->type }}">{{ $service->name }}</h3>
                            <hr>
                            <p>{{ $service->description }}</p>
                            
                            @if(isset($booking->booking_id))
                                <form action="/booking/{{ $booking->booking_id }}" method="post" enctype="multipart/form-data">
                            @else
                                <form action="/booking" method="post" enctype="multipart/form-data">
                            @endif
                            
                                {{ csrf_field() }}
                                
                                <input name="service_type_id" type="hidden" value="{{ $service->id }}">
                                <button name="btn_submit" type="submit" value="1" class="btn btn-warning hvr-wobble-vertical w-50 m-auto @if(isset($booking->service_type_id) && ($booking->service_type_id == $service->id)) active @endif">Select</button>
                                
                            </form>
                    </div>
                </div>
            @endforeach
           
        </div>
    
            
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Mode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="opt1" class="radio">
                                <input type="radio" name="mode" id="opt1" hidden class="hidden"/>
                                <span class="label"></span> I am picking up
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label for="opt2" class="radio">
                                <input type="radio" name="mode" id="opt2" hidden class="hidden"/>
                                <span class="label"></span> I need to be picked up
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="handleRedirect()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection
