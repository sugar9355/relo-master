@extends('admin.layout.base')

@section('title', 'Add Document ')

@section('content')

<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.document.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.document.add_Document')</h5>

            <form class="form-horizontal" action="{{route('admin.document.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.document.document_name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Document Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.document.document_type')</label>
                    <div class="col-md-10">
                        <select name="type">
                            <option value="DRIVER">@lang('admin.document.driver_review')</option>
                            <option value="VEHICLE">@lang('admin.document.vehicle_review')</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zipcode" class="col-md-12 col-form-label"></label>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">@lang('admin.document.add_Document')</button>
                        <a href="{{route('admin.document.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
