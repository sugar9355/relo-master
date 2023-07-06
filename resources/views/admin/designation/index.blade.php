@extends('admin.layout.base')

@section('title', 'Designation')

@section('content')

<!-- Accordion with right control button -->
@foreach ($badge_types as $key => $type)
<div class="card-group-control card-group-control-right" id="accordion-{{$key}}">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white"
                    href="#accordion-control-{{$key}}">{{$type->badge_type_name}}</a>
            </h6>
        </div>

        <div id="accordion-control-{{$key}}" class="collapse show" data-parent="#accordion-{{$key}}">
            <div class="card-body">
                <div class="row">
                    @foreach ($designations as $badge)
                    @if ($type->badge_type_id == $badge->badge_type)
                    <div class="col-lg-6">
                        <div class="card border-left-3 border-left-orange rounded-left-0">
                            <div class="card-body">
                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                    <div>
                                        <div class="form-inline">
                                            <span
                                                class="badge badge-flat border-orange text-orange-600 badge-icon mb-2 mr-2"><i
                                                    class="icon-medal-star icon-2x"></i></span>
                                            <h4 class="font-weight-semibold">{{$badge->name}}</h4>
                                        </div>
                                        <ul class="list list-unstyled mb-0">

                                            <li><span class="font-weight-semibold">Discription:</span></li>
                                            <li>{!!$badge->description!!}</li>
                                        </ul>
                                        @foreach (explode(',', $badge->roles) as $r)
                                        @foreach ($roles as $k => $role)
                                        @if($role->id == $r)
                                        <span class="badge badge-flat border-info text-info-600 badge-icon mt-2">
                                            <i class="icon-person"></i>{{ $role->name }}
                                        </span>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </div>

                                    <div class="text-sm-right mb-0 mt-3 mt-sm-0 ml-auto">
                                        <h6 class="font-weight-semibold">Amount</h6>
                                        <ul class="list list-unstyled mb-0">
                                            @if($badge->bonus == 0) <font color="red">N/A</font> @else
                                            {{ $badge->bonus }} @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                <span>
                                    <span class="badge badge-mark border-danger mr-2"></span>
                                    Updated:
                                    <span class="font-weight-semibold">{{$badge->updated_at}}</span>
                                </span>

                                <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                                    {{-- <li class="list-inline-item">
                                        <a href="#" class="text-default"><i class="icon-eye8"></i></a>
                                    </li> --}}
                                    <li class="list-inline-item dropdown">
                                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i
                                                class="icon-menu7"></i></a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ route('admin.designation.edit', $badge->id) }}"
                                                class="dropdown-item"><i class="icon-file-plus"></i>
                                                @lang('admin.edit')</a>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#delete_{{ $badge->id }}"><i class="icon-trash"></i> @lang('admin.delete')</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Modal -->
                            <div id="delete_{{ $badge->id }}" class="modal fade" role="dialog">
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
                                            <form action="{{ route('admin.designation.destroy', $badge->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" name="delete_badge" value="true" class="btn btn-success">Yes</button>
                                            </form>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- /accordion with right control button -->

@endsection