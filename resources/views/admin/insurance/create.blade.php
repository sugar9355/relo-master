@extends('admin.layout.base')

@section('title', 'Add Insurance Category ')

@section('content')

    <div class="card">
        <div class="card-body">
            <div >

                {{--<h5 style="margin-bottom: 2em;">@lang('admin.categroy.')</h5>--}}

                <form class="form-horizontal" action="{{route('admin.insurance.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.category_name')</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" requaired id="name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="width" class="col-md-12 col-form-label">@lang('admin.ratio')</label>
                        <div class="col-md-1">
                            <input class="form-control" type="text" value="" name="ratio[]" required id="ratio" placeholder="You Pay">
                        </div>
                        <div class="col-md-1">
                            <input class="form-control" type="text" value="" name="ratio[]" required id="ratio" placeholder="We Pay">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="you_pay" class="col-md-12 col-form-label">You Pay</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" value="{{old('you_pay')}}" name="you_pay" required id="you_pay" placeholder="You Pay">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="width" class="col-md-12 col-form-label">Suitable Bade For Given Threshold</label>
                        <div class="col-md-6">
                            <select name="badge_required" class="form-control">
                            @foreach($designations as $badge)
                                <option value="{{$badge->id}}">{{$badge->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <hr>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">Add Insurance Category</button>
                            <a href="{{route('admin.insurance.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
    $(function(){
        $(".select2").select2();
    });
</script>
@endsection
