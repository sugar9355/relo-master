@extends('admin.layout.base')

@section('title', 'Add Referral ')

@section('content')

        <div class="card card-body">                

                <h3 class="m-0">Add Referal 
                    <a href="{{ route('admin.referal.index') }}" class="btn btn-outline-dark pull-right"><i
                            class="fa fa-angle-left"></i> @lang('admin.back')</a></h3>
                    <hr>

                <form class="form-horizontal" action="{{route('admin.referal.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}

                    <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="name" class="form-label">@lang('admin.name')</label>
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name"
                                   placeholder="Name">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="bonus" class="form-label">Bonus Amount</label>
                            <input class="form-control" type="text" required name="bonus" value="{{old('bonus')}}" id="bonus" placeholder="Bonus Amount">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="level" class="form-label">Level</label>
                            <input class="form-control" type="text" name="level" id="level" value="{{ old('level') }}" placeholder="Level">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="hours" class="form-label">Hours</label>
                            <input class="form-control" type="text" name="hours" id="hours" value="{{ old('hours') }}" placeholder="Hours">
                    </div>

                    <!--div class="form-group">
                        <label for="days" class="col-md-12 col-form-label">Consecutive days</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="days" id="days" value="{{ old('days') }}" placeholder="Consecutive days">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Min</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ old('time') }}" name="time" required id="time"
                                   placeholder="5">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Med</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ old('time_med') }}" name="time_med" required id="time_med"
                                   placeholder="7">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-12 col-form-label">Time in Max</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ old('time_max') }}" name="time_max" required id="time_max"
                                   placeholder="10">
                        </div>

                    </div-->

                    </div>
                    
                    <hr>
                            <button type="submit" class="btn btn-primary">Add Referral</button>
                            <a href="{{route('admin.level.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                       
                </form>
            
        </div>

@endsection
