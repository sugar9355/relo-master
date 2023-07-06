@extends('admin.layout.base')

@section('title', 'Vehicle Schedule ')

@section('content')
<!-- Highlighting rows and columns -->
    <div class="card">
        <div class="card-header bg-white header-elements-sm-inline">
            <h6 class="card-title"> @lang('admin.vehicle.Vehicle_Schedule')</h6>
            {{-- <div class="header-elements">
                <a type="button" href="{{ route('admin.vehicleType.create') }}"  class="btn btn-dark text-white">Add New Vehicle Type</a>
            </div> --}}
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered">
            <thead>
                <tr class="bg-dark text-white">
                    <th class="text-center text-capitalize">ID</th>
                    <th class="text-center text-capitalize">name</th>
                    <th class="text-center text-capitalize">type</th>
                    <th class="text-center text-capitalize">color</th>
                    <th class="text-center text-capitalize">volume</th>
                    <th class="text-center text-capitalize">action</th>
                </tr>
            </thead>
                @foreach ($vehicles as $i => $v)
                    <tr>
                        <td class="text-center">{{$i + 1}}</td>
                        <td class="text-center">{{$v->name}}</td>
                        <td class="text-center">{{$v->type}}</td>
                        <td class="text-center" style="color : {{$v->color}}"><i class="icon-truck"></i></td>
                        <td class="text-right">{{$v->volume}}</td>
                        <td class="text-cetner" style="display: flex;align-items: center; justify-content: center">
                            <a href="{{ Route('admin.vehicle_schedule.calendar', $v->id) }}"><i class="icon-calendar22"></i></a>
                        </td>
                    </tr>
                @endforeach
            <tbody>
        </table>
    </div>
    
    <div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center"></div>
    </div>
    <!-- /highlighting rows and columns -->
   
@endsection
