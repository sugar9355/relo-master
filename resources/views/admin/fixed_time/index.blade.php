@extends('admin.layout.base')

@section('title', 'Fixed Times ')

@section('styles')
<style>
    .btn-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }
    .parking-name {
        display: flex;
        align-items: center;
    }
</style>
@endsection

@section('content')
<div class="card-group-control card-group-control-right" id="accordion">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Fixed Times</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <form class="form-horizontal" action="{{route('admin.fixed_time.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-6" id="parking_times">
                        @foreach ($parking_times as $time)
                        <div class="row mt-3">
                            <div class="col parking-name">{{$time->parking}}</div>
                            <div class="col">
                                <input class="form-control" type="text" name="parking_time[{{$time->id}}]" value="{{$time->time}}" />
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-6" id="additional_times">
                        @if (count($additional_times) != 0)
                        @for ($i = 0; $i < count($additional_times); $i++)
                        <div class="row" id="add_{{$i}}">
                            <div class="form-group col">
                                @if ($i == 0)
                                <label for="">Name</label>
                                @endif
                                <input class="form-control" type="text" name="add_name[]" value="{{$additional_times[$i]->name}}" />
                            </div>
                            <div class="form-group col">
                                @if ($i == 0)
                                <label for="">Time</label>
                                @endif
                                <input class="form-control" type="text" name="add_time[]" value="{{$additional_times[$i]->time}}" />
                            </div>
                            @if ($i == 0)
                            <div class="form-group col btn-container">
                                <button type="button" class="btn btn-success" id="add" value="{{count($additional_times)}}">Add more</button>
                            </div>
                            @else
                            <div class="form-group col btn-container">
                                <button type="button" class="btn btn-danger" onclick="remove({{$i}})">Remove</button>
                            </div>
                            @endif
                        </div>
                        @endfor
                        @else
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Name</label>
                                <input class="form-control" type="text" name="add_name[]" value="" />
                            </div>
                            <div class="form-group col">
                                <label for="">Time</label>
                                <input class="form-control" type="text" name="add_time[]" value="0" />
                            </div>
                            <div class="form-group col btn-container">
                                <button type="button" class="btn btn-success" id="add" value="1">Add more</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <hr>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane"></i></button>
                        <a href="{{route('admin.fixed_time.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(document).ready(function() {
        $('#add').click(function() {
            var id = parseInt($(this).val())
            $(this).val(id + 1)
            var res = '<div class="row" id="add_' + id + '"><div class="form-group col"><input class="form-control" type="text" name="add_name[]" value="" /></div><div class="form-group col"><input class="form-control" type="text" name="add_time[]" value="0" /></div><div class="form-group col btn-container"><button type="button" class="btn btn-danger" onclick="remove(' + id + ')">Remove</button></div></div>'

            $('#additional_times').append(res)
        })
    })

    function remove(i) {
        $('#add_' + i).remove()
    }
</script>
@endsection