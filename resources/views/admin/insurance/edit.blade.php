@extends('admin.layout.base')

@section('title', 'Edit Insurance Category ')

@section('content')

    <div class="card">
        <div class="card-body">
            <div >
                <a href="{{ route('admin.insurance.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

                <h5 style="margin-bottom: 2em;">Update Insurance Category</h5>
                <hr>
                <form class="form-horizontal" action="{{route('admin.insurance.update', $insuranceCategory->id)}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.category_name')</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" value="{{ $insuranceCategory->name }}" name="name" required id="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="width" class="col-md-12 col-form-label">@lang('admin.ratio')</label>
                        @php
                            $ratioArray = explode(':', $insuranceCategory->ratio);
                        @endphp
                        <div class="col-md-1">
                            <input class="form-control" type="text" value="{{ $ratioArray[0] }}" name="ratio[]" required id="ratio" placeholder="Ratio">
                        </div>
                        <div class="col-md-1">
                            <input class="form-control" type="text" value="{{ $ratioArray[1] }}" name="ratio[]" required id="ratio" placeholder="Ratio">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="you_pay" class="col-md-12 col-form-label">You Pay</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" value="{{ $insuranceCategory->you_pay }}" name="you_pay" required id="you_pay" placeholder="You Pay">
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
                            <button type="submit" class="btn btn-primary">Update Insurance Category</button>
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
        let selector = $('.select2');
        selector.select2();
        let selected = $('#itemIdsVal').val().split(",");
        selector.val(selected);
        selector.change();
    });

    function addToDescription(me, resDiv) {
        let val = $(me).val().join(',');
        $(resDiv).val(val);
    }
</script>
<script>
    $(function(){
        $('.redio').on('click', function(event){
            $('.active').removeClass('active fa-circle').addClass('fa-circle-thin');
            let parentSelector = $(event.currentTarget);
            let selector = parentSelector.find('i');
            selector.removeClass('fa-circle-thin');
            selector.addClass('fa-circle active');
            let val = parentSelector.parent().find('h5').text();
            $("#accuracy").val(val);
        })
    });
</script>
@endsection
