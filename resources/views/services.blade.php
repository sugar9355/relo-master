@extends('user.layout.app')

@section('styles')

@endsection

@section('content')

    <!--ENDS HEADING-->
    <!--STARTS SLIDER-->

    <!--END SLIDERS-->

    <!--SEARCH BAR STARTS-->
	
	
    <div class="container my-5">
	
	<form action="/" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
	   <h1 class="text-center">SERVICE TYPE</h1>
        <hr>
		<div class="row">
			@foreach($services as $service)
				<div class="col-6 mt-3">
					<div class="card card-body rounded text-center hvr-shadow d-block {{ ($service->name == $selected) ? 'my-custom-active' : null }}">                        
						<!--img class="card-img-top" src="{{ $service->image }}" alt="Avatar"-->
							<h3 class="m-0" data-val="{{ $service->type }}">{{ $service->name }}</h3>
							<hr>
							<p>{{ $service->description }}</p>
							<button name="serviceType[]" type="submit" value="{{ $service->name }}" class="btn btn-warning w-50 m-auto">Select</button>
					</div>
				</div>
			@endforeach
		   
		</div>
	</form>
			
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

@section('scripts')

    <script>
        let formSubmit = false;
	    function handleRedirect() {
	    	let val = $("#opt1").prop('checked');
		    if (val){
		    	formSubmit = true;
		    	$("#formLocation").submit();
		    	return;
            }

		    window.location.href = '{{ route('login') }}'
	    }
		
		function select_service(service)
		{
			$("#service").val(service);
		}

		$(function () {
			
			$('.ca-item-main').on('click', function (event) {
				$(".my-custom-active").removeClass("my-custom-active");
				let me = $(event.currentTarget);
				let selector = me.find('h3');
				let val = selector.text();
				let dataVal = selector.data('val');
				let input = $("#service");
				input.val(val);
				input.data('val', dataVal);
				me.addClass("my-custom-active");
			});

			$("#formLocation").on('submit', function (evt) {
				if (!formSubmit){
					evt.preventDefault();
					let input = $("#service");
					console.log(input);
					let dataVal = input.data('val');
					if (dataVal === 'Storage') {
						$(".modal").modal();
					}else{

                        formSubmit = true;
		    	$("#formLocation").submit();
		    	return;

                    }
				}
			});
		});
    </script>

@endsection
