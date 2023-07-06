@extends('admin.layout.base')

@section('title', 'New Demand ')

@section('content')

<div class="card">
    <div class="card-body">

        <a href="{{ route('admin.peakfactor.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
            @lang('admin.back')</a>

        <h5 style="margin-bottom: 2em;">Reservation Fee</h5>

        <form class="form-horizontal" action="{{route('admin.reservation_fee_store')}}" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
            @foreach ($trucks as $t)
            <div class="form-group">
                <label for="" class="col-md-12 col-form-label"><span class="text-warning">{{$t->name}}</span>&nbsp;&nbsp;&nbsp;{{$t->type}}</label>
                <div class="col-md-2">
                    <input class="form-control fee" type="text" value="{{$t->fee}}" required data-id="{{$t->id}}" placeholder="Reservation Fee">
                </div>
            </div>
            @endforeach

            <hr>
            <input type="hidden" name="demand_id" value="{{$demand_id}}" />
            <input type="hidden" name="fees" id="fees" />

            <button type="submit" class="btn btn-primary ml-3">Submit <i class="icon-paperplane ml-2"></i></button>

        </form>
    </div>

</div>

@endsection
@section ('scripts')
<script src=""></script>
<script>
	var fees = {
	@foreach ($trucks as $c)
		"{{$c->id}}": { "vehicle_id": "{{ $c->id }}", "fee": "{{ $c->fee }}" }, 
	@endforeach
	};
	$('#fees').val(JSON.stringify(fees))
	console.log($('#fees').val())

	$(".fee").keyup(function() {
		var id = $(this).data('id');
		fees[id].fee = $(this).val();
		$('#fees').val(JSON.stringify(fees))
		console.log($('#fees').val())
	})
</script>
@endsection