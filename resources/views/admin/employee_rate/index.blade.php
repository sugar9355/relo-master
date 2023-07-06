@extends('admin.layout.base')

@section('title', 'Providers ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            @if(Setting::get('demo_mode') == 1)
        <div class="col-md-12" style="height:50px;color:red;">
                    ** Demo Mode : No Permission to Edit and Delete.
                </div>
                @endif
            <h5 class="mb-1">
                Employees Rates
                @if(Setting::get('demo_mode', 0) == 1)
                <span class="pull-right">(*personal information hidden in demo)</span>
                @endif
            </h5>
            
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        
						<th>captain</th>
                        <th>helper</th>
                        <th>technician</th>
                        <th>refer_captain</th>
                        <th>refer_helper</th>
                        <th>refer_technician</th>
                        <th>Unit</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rates as $index => $rate)
                    <tr>
                        
						<td>{{ $rate->captain_per_hour }} {{$rate->unit}}</td>
						<td>{{ $rate->helper_per_hour }} {{$rate->unit}}</td>
						<td>{{ $rate->technician_per_hour }} {{$rate->unit}}</td>
						<td>{{ $rate->refer_captain_per_hour }} {{$rate->unit}}</td>
						<td>{{ $rate->refer_helper_per_hour }} {{$rate->unit}}</td>
						<td>{{ $rate->refer_technician_per_hour }} {{$rate->unit}}</td>
						<td>{{$rate->unit}}</td>
						
                        <td>
                            <div class="input-group-btn">
                               
                                    @if( Setting::get('demo_mode') == 0)
                                   
                                        <a href="{{ route('admin.employee_rate.edit', $rate->amount_id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                    
                                    @endif
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              
            </table>
        </div>
    </div>
</div>
@endsection