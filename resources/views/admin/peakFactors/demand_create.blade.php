@extends('admin.layout.base')

@section('title', 'New Demand ')

@section('content')

<div class="card">
    <div class="card-body">

        <a href="{{ route('admin.peakfactor.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
            @lang('admin.back')</a>

        <h5 style="margin-bottom: 2em;">Add New Demand Type</h5>

        <form class="form-horizontal" action="{{route('admin.demand_store')}}" method="POST" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
            <div class="form-group">
                <label for="demand_name" class="col-md-12 col-form-label">Demand Type</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="{{ old('demand_name') }}" name="demand_name" required id="demand_name" placeholder="Demand Name">
                </div>
            </div>

            <div class="form-group">
                <label for="min" class="col-md-12 col-form-label">Min</label>
                <div class="col-md-10">
                    <input class="form-control" type="number" value="{{ old('min') }}" name="min" required id="min" placeholder="Min Value" step="0.01">
                </div>
            </div>

            <div class="form-group">
                <label for="max" class="col-md-12 col-form-label">Max</label>
                <div class="col-md-10">
                    <input class="form-control" type="number" required name="max" value="{{ old('max') }}" id="max" placeholder="Max Value" step="0.01">
                </div>
            </div>

            <div class="form-group">
                <label for="max" class="col-md-12 col-form-label">Color</label>
                <div class="col-md-1">
                    <input class="form-control" type="color" required name="color" value="{{ old('color') }}" id="color" placeholder="ex: #000000" style="height: 40px">
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary ml-3">Submit <i class="icon-paperplane ml-2"></i></button>

        </form>
    </div>

</div>

@endsection