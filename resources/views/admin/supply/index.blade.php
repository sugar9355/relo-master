@extends('admin.layout.base')

@section('title', 'Packing Supplies ')

@section('content')

<div class="card-group-control card-group-control-right" id="accordion">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Packing Supplies</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    @foreach($supplies as $supply)
                    <div class="col-4">
                        <div class="card rounded-left-0" style="border-top: solid 3px #af7826">
                            <div class="card-body">
                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                    <div>
                                        <div class="form-inline mb-3">
                                            <span class="badge badge-flat badge-icon mb-2 mr-2"><i class="icon-box-remove icon-2x" style="color: #af7826"></i></span>
                                        </div>

                                        <h6 class="font-weight-semibold">Name</h6>
                                        <div class="form-inline">
                                            <span class="mb-2 mr-2"><i class="icon-box-remove" style="color: #af7826"></i>&nbsp;&nbsp;{{ $supply->name }}</span>
                                        </div>

                                        <h6 class="font-weight-semibold">Cost</h6>
                                        <div class="form-inline">
                                            <span class="mb-2 mr-2"><i class="icon-coins" style="color: #af7826"></i>&nbsp;&nbsp;{{ $supply->cost }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                <span>
                                    <span class="badge badge-mark border-danger mr-2"></span>
                                    Last Updated:
                                    <span class="font-weight-semibold">{{$supply->updated_at}}</span>
                                </span>

                                <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                                    <li class="list-inline-item dropdown">
                                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ Route('admin.supply.edit', $supply->id) }}" class="dropdown-item"><i class="icon-file-plus text-primary"></i>@lang('admin.edit')</a>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#delete_{{ $supply->id }}"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="delete_{{ $supply->id }}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title">Are You Sure ?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body  text-center">
                                    <hr>
                                    Do you want to delete Selected ?
                                    <hr>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.supply.destroy', $supply->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" name="delete_supply" value="true" class="btn btn-success">Yes</button>
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
@endsection