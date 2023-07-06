@extends('admin.layout.base')
 <link rel="stylesheet" href="{{ asset('asset/css/newDesignStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('noUiSlider/nouislider.css') }}">
	
@section('title', 'Update User ')

@section('content')
<div class="card">
<div class="card-header"><h5 class="mb-1">@lang('admin.users.Users')</h5></div>

<div class="card-body">

<div class="table-responsive">
<table class="table table-striped table-bordered">
<thead>
<tr>
	<th>SNo</th>
	<th>Booking Date</th>
	<th>Start Time</th>
	<th>End Time</th>
	
	
</tr>
</thead>
<tbody>
@foreach($user_booking as $index => $user)
<tr>
	<td>{{ $index + 1 }}</td>
	<td>{{ $user->booking_date }}</td>
	<td>{{ $user->start_time }}</td>
	<td>{{ $user->end_time }}</td>
	
</tr>
@endforeach
</tbody>

</table>
</div>
</div>

</div>
@endsection
