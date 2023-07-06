@extends('admin.layout.base')

@section('title', 'Edit Preset ')

@section('content')

<div class="card">
    <div class="card-body">
        <div>
            <a href="{{ route('admin.preset.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">@lang('admin.preset.Update_Preset')</h5>

            <form class="form-horizontal" action="{{route('admin.preset.update', $preset->id)}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">

                <div class="form-group">
                    <label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $preset->name }}" name="name" required id="name" placeholder="Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="picture" class="col-md-12 col-form-label">Picture</label>
                    <div class="col-md-10">
                        @if(isset($preset->image))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$preset->image}}">
                        @endif
                        <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 col-form-label" for="supply">@lang('admin.include.supplies'):</label>
                    <div class="col-md-10">
                        <select name="supply" class="form-control" id="supply">
                            <option></option>
                            @foreach($supplies as $supply)
                            <option value="{{ $supply->id }}" id="{{ $supply->id }}" @if ($supply->id == $preset->supply) selected @endif>{{ $supply->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 col-form-label" for="time">@lang('admin.time'):</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ isset($preset->time) ? $preset->time : null }}" name="time" id="time" placeholder="Min Time">
                    </div>
                </div>

                <div class="form-group">
                    <label for="item_ids" class="col-md-12 col-form-label">@lang('admin.inventory.Items')</label>
                    <div class="col-md-10">
                        <p style="display: none" id="itemIdsVal">{{ $preset->item_ids }}</p>
                        <select name="item_ids[]" class="form-control select2" id="item_ids" multiple>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @php
                $item_ids = explode(',', $preset->item_ids);
                if ($preset->item_quantity != '') {
                    $item_quantity = explode(',', $preset->item_quantity);
                    $quantities = [];
                    $i = 0;

                    foreach($item_ids as $id) {
                        $quantities[$id] = $item_quantity[$i];
                        $i++;
                    }
                }
                @endphp

                @foreach ($items as $item)
                <div class="form-group quantity-fields" style="display: none">
                    <label for="" class="col-md-12 col-form-label">{{$item->name}} Quantity</label>
                    <div class="col-md-10">
                        <input class="form-control col-md-4" type="number" name="quantity_{{$item->id}}" id="quantity_{{$item->id}}" value="{{(isset($quantities[$item->id])) ? $quantities[$item->id] : 0}}" />
                    </div>
                </div>
                @endforeach

                <div class="form-group">
                    <hr>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">@lang('admin.preset.Update_Preset')</button>
                        <a href="{{ route('admin.preset.index') }}" class="btn btn-default">@lang('admin.cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let selector = $('.select2');
        selector.select2();
        let selected = $('#itemIdsVal').html().split(",");
        selector.val(selected);
        selector.change();

        $('#supply').select2({
            placeholder: "Select a Supply",
            allowClear: true
        })

        selected.map(function(id) {
            $("#quantity_" + id).parent().parent().show()
        })

        $('#item_ids').on('change', function() {
            $('.quantity-fields').hide()
            var item_ids = $(this).val()
            item_ids.map(function(id) {
                $("#quantity_" + id).parent().parent().show()
            })
        })
    });
</script>


@endsection