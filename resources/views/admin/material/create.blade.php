@extends('admin.layout.base')

@section('title', 'Add Preset ')

@section('content')

<div class="row">
    <div class="col-md-6">
        
        <!-- Left aligned buttons -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title"> Add Material</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form class="" action="{{route('admin.material.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>@lang('admin.name'):</label>
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Name">
                    </div>
                    
                    <div class="form-group">
                        <label>Price:</label>
                        <input class="form-control" type="text" value="{{ old('price') }}" name="price" required id="price" placeholder="Price">
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="qty_show">
                        <label class="form-check-label" for="qty_show">Input Qty</label>
                    </div>

                    <div class="form-group" style="display: none" id="qty_input">
                        <label>Quantity:</label>
                        <input class="form-control" type="text" name="qty" required id="qty" placeholder="Quantity" value="0">
                    </div>

                    <div class="d-flex justify-content-start align-items-center">
                        <a href="{{ route('admin.material.index') }}" class="btn btn-light">@lang('admin.cancel')</a>
                        <button type="submit" class="btn bg-blue ml-1">Add Material <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /left aligned buttons -->
    </div>
</div>

@endsection
@section('scripts')
    <script>
        $(function() {
            $('#qty_show').change(function() {
                if (this.checked) {
                    $('#qty_input').show();
                } else {
                    $('#qty_input').hide();
                }
            });
        });
    </script>
@endsection
