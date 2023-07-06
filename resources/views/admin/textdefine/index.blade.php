@extends('admin.layout.base')

@section('title', 'Text Define ')

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
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Text Define</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <form class="form-horizontal" action="{{route('admin.text-defination-save')}}" method="POST"
                    role="form">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-12" id="parking_times">
                            <div class="row">
                                <input name="textid" hidden value="{{$textdefine[0]->id}}">
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Color</label>
                                    <span class="input-group-prepend">
                                        <input name="color" type="color" value="{{$textdefine[0]->color}}"
                                            class="form-control form-control-lg" style="height: 40px" required="">
                                    </span>
                                </div>
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Font Size</label>
                                    <span class="input-group-prepend">
                                        <input name="fontsize" type="number" value="{{$textdefine[0]->font_size}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                                <div class="col-md-6 pl-3">
                                    <label class="mt-1">Text</label>
                                    <span class="input-group-prepend">
                                        <input name="textname" type="text" value="{{$textdefine[0]->name}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <input name="text_id_flexible" hidden value="2">
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Color</label>
                                    <span class="input-group-prepend">
                                        <input name="color_flexible" type="color" value="{{$textdefine[1]->color}}"
                                            class="form-control form-control-lg" style="height: 40px" required="">
                                    </span>
                                </div>
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Font Size</label>
                                    <span class="input-group-prepend">
                                        <input name="font_size_flexible" type="number" value="{{$textdefine[1]->font_size}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                                <div class="col-md-6 pl-3">
                                    <label class="mt-1 text-capitalize">Text (flexible)</label>
                                    <span class="input-group-prepend">
                                        <input name="text_name_flexible" type="text" value="{{$textdefine[1]->name}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <input name="text_id_unflexible" hidden value="3">
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Color</label>
                                    <span class="input-group-prepend">
                                        <input name="color_unflexible" type="color" value="{{$textdefine[2]->color}}"
                                            class="form-control form-control-lg" style="height: 40px" required="">
                                    </span>
                                </div>
                                <div class="col-md-3 pl-3">
                                    <label class="mt-1">Font Size</label>
                                    <span class="input-group-prepend">
                                        <input name="font_size_unflexible" type="number" value="{{$textdefine[2]->font_size}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                                <div class="col-md-6 pl-3">
                                    <label class="mt-1 text-capitalize">Text (unflexible)</label>
                                    <span class="input-group-prepend">
                                        <input name="text_name_unflexible" type="text" value="{{$textdefine[2]->name}}"
                                            class="form-control form-control-lg" required="">
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <hr>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">Create <i
                                    class="icon-paperplane"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection