@extends('admin.layout.base')

@section('title', 'Add Service Type ')

@section('content')
<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.services.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.service.Add_Service_Type')</h5>

            <form class="form-horizontal" action="{{route('admin.services.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.service.Service_Name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Service Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-12 col-form-label">@lang('admin.service.Description')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('description') }}" name="description" required id="description" placeholder="Description">
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-md-12 col-form-label">@lang('admin.type')</label>
                    <div class="col-md-10">
                        <select class="form-control" type="text" name="type" required id="type">
                            <option value="Normal" selected>Normal</option>
                            <option value="Storage">Storage</option>
                            <option value="Junk Removal">Junk Removal</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="picture" class="col-md-12 col-form-label">
                    @lang('admin.service.Service_Image')</label>
                    <div class="col-md-10">
                        <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group">
                    <label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" value="{{ (old('color')) ? old('color') : '#000000'}}" name="color" required id="color" placeholder="Color">
                    </div>
                    <div class="col-md-2">
                        <div id="colorpicker"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-3">
                                <a href="{{ route('admin.services.index') }}" class="btn btn-danger btn-block">@lang('admin.cancel')</a>
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
