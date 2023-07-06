@extends('admin.layout.base')

@section('title', 'Add Service Type ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.service.Add_Service_Type')</h5>

            <form class="form-horizontal" action="{{route('admin.service.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.service.Service_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Service Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="provider_name" class="col-md-12 col-form-label">@lang('admin.service.Provider_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('provider_name') }}" name="provider_name" required id="provider_name" placeholder="Provider Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="picture" class="col-md-12 col-form-label">
                    @lang('admin.service.Service_Image')</label>
                    <div class="col-md-10">
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fixed" class="col-md-12 col-form-label">@lang('admin.service.Base_Price') ({{ currency() }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('fixed') }}" name="fixed" required id="fixed" placeholder="Base Price">
                    </div>
                </div>

                <div class="form-group">
                    <label for="distance" class="col-md-12 col-form-label">@lang('admin.service.Base_Distance') ({{ distance() }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('distance') }}" name="distance" required id="distance" placeholder="Base Distance">
                    </div>
                </div>

                <div class="form-group">
                    <label for="minute" class="col-md-12 col-form-label">@lang('admin.service.unit_time')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('minute') }}" name="minute" required id="minute" placeholder="Unit Time Pricing">
                    </div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-md-12 col-form-label">@lang('admin.service.unit')({{ distance() }})</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('price') }}" name="price" required id="price" placeholder="Unit Distance Price">
                    </div>
                </div>

                <div class="form-group">
                    <label for="capacity" class="col-md-12 col-form-label">@lang('admin.service.Seat_Capacity')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" value="{{ old('capacity') }}" name="capacity" required id="capacity" placeholder="Capacity">
                    </div>
                </div>

                <div class="form-group">
                    <label for="calculator" class="col-md-12 col-form-label">@lang('admin.service.Pricing_Logic')</label>
                    <div class="col-md-10">
                        <select class="form-control" id="calculator" name="calculator">
                            <option value="MIN">@lang('servicetypes.MIN')</option>
                            <option value="HOUR">@lang('servicetypes.HOUR')</option>
                            <option value="DISTANCE">@lang('servicetypes.DISTANCE')</option>
                            <option value="DISTANCEMIN">@lang('servicetypes.DISTANCEMIN')</option>
                            <option value="DISTANCEHOUR">@lang('servicetypes.DISTANCEHOUR')</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-12 col-form-label">@lang('admin.service.Description')</label>
                    <div class="col-md-10">
                        <textarea class="form-control" type="number" value="{{ old('description') }}" name="description" required id="description" placeholder="Description" rows="4"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-3">
                                <a href="{{ route('admin.service.index') }}" class="btn btn-danger btn-block">@lang('admin.cancel')</a>
                            </div>
                            <div class="col-md-12 col-sm-6 offset-md-6 col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">@lang('admin.service.Add_Service_Type'
                                )</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
