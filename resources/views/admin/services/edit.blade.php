@extends('admin.layout.base')

@section('title', 'Update Service Type ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.services.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.service.Update_Service_Type')</h5>

            <form class="form-horizontal" action="{{route('admin.services.update', $service->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.service.Service_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->name }}" name="name" required id="name" placeholder="Service Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="provider_name" class="col-md-12 col-form-label">@lang('admin.service.Description')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $service->description }}" name="description" required id="description" placeholder="Description">
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-md-12 col-form-label">@lang('admin.type')</label>
                    <div class="col-md-10">
                        <select class="form-control" type="text" name="type" required id="type">
                            <option value="Normal" {{ ($service->type == "Normal") ? 'Selected' : null }}>Normal</option>
                            <option value="Storage" {{ ($service->type == "Storage") ? 'Selected' : null }}>Storage</option>
                            <option value="Junk Removal" {{ ($service->type == "Junk Removal") ? 'Selected' : null }}>Junk Removal</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">

                    <label for="image" class="col-md-12 col-form-label">@lang('admin.picture')</label>
                    <div class="col-md-8">
                        <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                    </div>
                    @if(isset($service->image))
                        <div class="col-md-2">
                            <img style="height: 100px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" value="{{ $service->color }}" name="color" required id="color" placeholder="Color">
                    </div>
                    <div class="col-md-2">
                        <div id="colorpicker"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-sm-6 col-md-3">
                        <a href="{{route('admin.services.index')}}" class="btn btn-danger btn-block">@lang('admin.cancel')</a>
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
