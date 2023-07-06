@extends('admin.layout.base')

@section('title', 'Update Service Type ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.service.Update_User')</h5>

            <form class="form-horizontal" action="{{route('admin.service.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group">
                    <label for="name" class="col-md-2 col-form-label">@lang('admin.service.Service_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->name }}" name="name" required id="name" placeholder="Service Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="provider_name" class="col-md-2 col-form-label">@lang('admin.service.Provider_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->provider_name }}" name="provider_name" required id="provider_name" placeholder="Provider Name">
                    </div>
                </div>

                <div class="form-group">
                    
                    <label for="image" class="col-md-2 col-form-label">@lang('admin.picture')</label>
                    <div class="col-md-10">
                        @if(isset($service->image))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                        @endif
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fixed" class="col-md-2 col-form-label">@lang('admin.service.Base_Price') ({{ currency('') }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->fixed }}" name="fixed" required id="fixed" placeholder="Base Price">
                    </div>
                </div>

                <div class="form-group">
                    <label for="distance" class="col-md-2 col-form-label">@lang('admin.service.Base_Distance') ({{ distance('') }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->distance }}" name="distance" required id="distance" placeholder="Base Distance">
                    </div>
                </div>

                <div class="form-group">
                    <label for="minute" class="col-md-2 col-form-label">@lang('admin.service.unit_time') ({{ currency() }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->minute }}" name="minute" required id="minute" placeholder="Unit Time Pricing">
                    </div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-md-2 col-form-label">@lang('admin.service.unit') ({{ distance() }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->price }}" name="price" required id="price" placeholder="Unit Distance Price">
                    </div>
                </div>

                 <div class="form-group">
                    <label for="capacity" class="col-md-2 col-form-label">@lang('admin.service.Seat_Capacity')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" value="{{ $service->capacity }}" name="capacity" required id="capacity" placeholder="Seat Capacity">
                    </div>
                </div>

                <div class="form-group">
                    <label for="calculator" class="col-md-2 col-form-label">@lang('admin.service.Pricing_Logic')</label>
                    <div class="col-md-10">
                        <select class="form-control" id="calculator" name="calculator">
                            <option value="MIN" @if($service->calculator =='MIN') selected @endif>@lang('servicetypes.MIN')</option>
                            <option value="HOUR" @if($service->calculator =='HOUR') selected @endif>@lang('servicetypes.HOUR')</option>
                            <option value="DISTANCE" @if($service->calculator =='DISTANCE') selected @endif>@lang('servicetypes.DISTANCE')</option>
                            <option value="DISTANCEMIN" @if($service->calculator =='DISTANCEMIN') selected @endif>@lang('servicetypes.DISTANCEMIN')</option>
                            <option value="DISTANCEHOUR" @if($service->calculator =='DISTANCEHOUR') selected @endif>@lang('servicetypes.DISTANCEHOUR')</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-sm-6 col-md-3">
                        <a href="{{route('admin.service.index')}}" class="btn btn-danger btn-block">@lang('admin.cancel')</a>
                    </div>
                    <div class="col-md-12 col-sm-6 offset-md-6 col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">@lang('admin.service.Update_Service_Type')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection