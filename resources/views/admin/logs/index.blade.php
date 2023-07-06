@extends('admin.layout.base')

@section('title', 'Vehicle Logs')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h5 class="mb-1">
                    @lang('admin.include.logs')
                </h5>
                <form class="form-horizontal" action="{{ Route('admin.logs.search') }}" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="type" class="col-md-12 col-form-label">@lang('admin.selectVehicle')</label>
                        <div class="col-md-10">
                            <select class="form-control" name="vehicle" id="vehicle">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.logsCategory')</label>
                        <div class="col-md-10">
                            <select class="form-control" name="category" id="category">
                                <option value="">Select Log Category</option>
                                <option value="service"> Service Log</option>
{{--                                <option value="fuel"> Fuel Log</option>--}}
                                <option value="sticker"> Sticker Log</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <hr>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">@lang('admin.search')</button>
                        </div>
                    </div>
                </form>
                @if(isset($logs) && $logs)
                    <table class="table table-striped table-bordered dataTable" id="table-2">
                        <thead>
                        <tr>
                            <th>@lang('admin.sr')</th>
                            @if($serviceCheck)
                                <th>@lang('admin.current_miles')</th>
                                <th>@lang('admin.next_miles')</th>
                            @endif
                            @if($stickerCheck)
                                <th>@lang('admin.sticker_number')</th>
                                <th>@lang('admin.description')</th>
                            @endif
                            <th>@lang('admin.from')</th>
                            <th>@lang('admin.to')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($logs as $log)
                            <tr>
                                <td> {{ $i++ }} </td>
                                @if($serviceCheck)
                                    <td> {{ $log->miles }} </td>
                                    <td> {{ $log->next_miles }} </td>
                                @endif
                                @if($stickerCheck)
                                    <td> {{ $log->sticker_number }} </td>
                                    <td> {{ $log->description }} </td>
                                @endif
                                <td> {{ $log->from }} </td>
                                <td> {{ $log->to }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>@lang('admin.sr')</th>
                            @if($serviceCheck)
                                <th>@lang('admin.current_miles')</th>
                                <th>@lang('admin.next_miles')</th>
                            @endif
                            @if($stickerCheck)
                                <th>@lang('admin.sticker_number')</th>
                                <th>@lang('admin.description')</th>
                            @endif
                            <th>@lang('admin.from')</th>
                            <th>@lang('admin.to')</th>
                        </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
