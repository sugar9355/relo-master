@extends('admin.layout.base')

@section('title', 'Add Preset ')

@section('content')

<div class="row">
    <div class="col-md-6">

        <!-- Left aligned buttons -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">@lang('admin.preset.Add_Preset')</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form class="" action="{{route('admin.preset.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>@lang('admin.name'):</label>
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.picture'):</label>
                        <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.include.supplies'):</label>
                        <select name="supply" class="form-control select2" id="supply">
                            @foreach($supplies as $supply)
                            <option value="{{ $supply->id }}" id="{{ $supply->id }}">{{ $supply->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.time'):</label>
                        <input class="form-control" type="text" value="{{ old('time') }}" name="time" id="time" placeholder="Min Time">
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.inventory.Items'):</label>
                        <select name="item_ids[]" class="form-control select2" id="item_ids" multiple>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach ($items as $item)
                    <div class="form-group quantity-fields" style="display: none">
                        <label for="">{{$item->name}} Quantity</label>
                        <input class="form-control col-md-4" type="number" name="quantity_{{$item->id}}" id="quantity_{{$item->id}}" value="0" />
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-start align-items-center">
                        <a href="{{ route('admin.preset.index') }}" class="btn btn-light">@lang('admin.cancel')</a>
                        <button type="submit" class="btn bg-blue ml-1">@lang('admin.preset.Add_Preset') <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /left aligned buttons -->
    </div>
</div>

<script>
    $(document).ready(function() {
        let selector = $('.select2');
        selector.select2();

        $('#item_ids').on('change', function() {
            $('.quantity-fields').hide()
            var item_ids = $(this).val()
            item_ids.map(function(id) {
                $("#quantity_" + id).parent().show()
            })
        })
    });
</script>
@endsection