@extends('admin.layout.base')

@section('title', 'Flags ')

@section('content')
<!-- Accordion with right control button -->

<div class="card-group-control card-group-control-right" id="accordion">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Flags</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    @foreach($flags as $index => $flag)
                    <div class="col-lg-12">
                        <div class="card rounded-left-0" style="border-left-color: {{$flag->color}};border-left-width: 2px">
                            <div class="card-body">
                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                    <div>
                                        <div class="form-inline mb-3">
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-flag7 icon-2x" style="color: {{$flag->color}}"></i></span>
                                        </div>

                                        @if (isset($flag->zones))
                                        <h6 class="font-weight-semibold">Zones</h6>
                                        <div class="form-inline">
                                            @php
                                                $zone_ids = explode(',', $flag->zones); 
                                            @endphp
                                            @foreach($zone_ids as $zone_id)
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-location3"></i> {{ isset($zones[$zone_id]) ? $zones[$zone_id] : '' }}</span>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if (isset($flag->categories))
                                        <h6 class="font-weight-semibold">Categories</h6>
                                        <div class="form-inline">
                                            @php
                                                $category_ids = explode(',', $flag->categories); 
                                            @endphp
                                            @foreach($category_ids as $category_id)
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-furniture"></i> {{ isset($categories[$category_id]) ? $categories[$category_id] : '' }}</span>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if (isset($flag->items))
                                        <h6 class="font-weight-semibold">Inventory Items</h6>
                                        <div class="form-inline">
                                            @php
                                                $item_ids = explode(',', $flag->items); 
                                            @endphp
                                            @foreach($item_ids as $item_id)
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-furniture"></i> {{ $items[$item_id] }}</span>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if (isset($flag->num_flights))
                                        <h6 class="font-weight-semibold">Number of Flights</h6>
                                        <div class="form-inline">
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-stairs"></i> {{ $flag->num_flights }}</span>
                                        </div>
                                        @endif

                                        @if (isset($flag->type_flights))
                                        <h6 class="font-weight-semibold">Stair Type</h6>
                                        <div class="form-inline">
                                            <span class="badge badge-flat badge-icon mb-2 mr-2" style="border-color: {{$flag->color}};color: {{$flag->color}};"><i class="icon-stairs"></i> {{ $flag->type_flights }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                <span>
                                    <span class="badge badge-mark border-danger mr-2"></span>
                                    Last Updated:
                                    <span class="font-weight-semibold">{{$flag->updated_at}}</span>
                                </span>

                                <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                                    <li class="list-inline-item dropdown">
                                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ Route('admin.flag.edit', $flag->id) }}" class="dropdown-item"><i class="icon-file-plus text-primary"></i>@lang('admin.edit')</a>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#delete_{{ $flag->id }}"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="delete_{{ $flag->id }}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title">Are You Sure ?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body  text-center">
                                    <hr>
                                    Do you want to delete Selected Row ?
                                    <hr>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.flag.destroy', $flag->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" name="delete_flag" value="true" class="btn btn-success">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<!-- /accordion with right control button -->
@endsection