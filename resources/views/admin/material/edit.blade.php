@extends('admin.layout.base')

@section('title', 'Edit Material ')

@section('content')

<!-- Left aligned buttons -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Update Meterial</h6>
                <div class="header-elements">
                    
                </div>
            </div>

            <div class="card-body">
                <form class="form-horizontal" action="{{route('admin.material.update', $material->id)}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group">
                        <label>Name:</label>
                        <input class="form-control" type="text" value="{{ $material->name }}" name="name" required id="name" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label>Price:</label>
                        <input class="form-control" type="text" value="{{ $material->price }}" name="price" required id="price" placeholder="Price">
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="qty_show"@if($material->qty != 0) checked @endif>
                        <label class="form-check-label" for="qty_show">Input Qty</label>
                    </div>

                    <div class="form-group" id="qty_input" style="@if($material->qty == 0) display: none @endif">
                        <label>Quantity:</label>
                        <input class="form-control" type="text" name="qty" required id="qty" placeholder="Quantity" value="{{$material->qty}}">
                    </div>

                    <div class="d-flex justify-content-start align-items-center">
                        <a href="{{ route('admin.material.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn bg-blue ml-3">Update <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /left aligned buttons -->

    <script>
        $(document).ready(function() {
            let selector = $('.select2');
            selector.select2();
            let selected = $('#itemIdsVal').html().split(",");
            selector.val(selected);
            selector.change();
        });
    </script>


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
