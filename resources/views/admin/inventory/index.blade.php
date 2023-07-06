@extends('admin.layout.base')
@section('title', 'Items ')


@section('content')

<!-- Theme JS files -->
    <script src="{{asset('assets_admin/js/plugins/media/fancybox.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/demo_pages/ecommerce_product_list.js')}}"></script>
    <!-- /theme JS files -->


<script src="{{asset('assets_admin/js/plugins/uploaders/dropzone.min.js')}}"></script>
<!-- Theme JS files -->
    <script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>

    
    <script src="{{asset('assets_admin/js/demo_pages/uploader_bootstrap.js')}}"></script>
    <!-- /theme JS files -->

    <!-- Highlighting rows and columns -->
    <div class="card">
    <div class="card-header bg-white header-elements-sm-inline">
    <h6 class="card-title">Inventory Items</h6>
    <div class="header-elements">
        
        <div class="row row-tile no-gutters">
    
            <div class="col-md-4">
                <a href="{{ route('admin.inventory.create') }}" class="btn btn-light btn-block btn-float m-0 mb-1" >
                    <i class="icon-folder-plus text-blue-400 icon-2x"></i>
                    <span>Add New Item</span>
                </a>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-light btn-block btn-float m-0 mb-1" data-toggle="modal" data-target="#upload_excel">
                    <i class="icon-upload text-pink-400 icon-2x"></i>
                    <span>Excel Upload</span>
                </button>
                <!-- Modal -->
                <div id="upload_picture" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Upload Items Picture / Excel</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <!-- Dropzone -->
                        
                            <form class="dropzone" id="dropzone_multiple" action="{{route('admin.inventory.store')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="upload_excel_sheet" value="true">
                            </form>
                        
                        <!-- /dropzone -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>

                </div>
                </div>
                <div id="upload_excel" class="modal fade bd-example-modal-lg" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Upload Excel File</h4>
                                <button class="close" data-dismiss="modal" type="button">&times;</button>
                            </div>
                            <form action="{{route('admin.inventory.store')}}" class="m-0" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="modal-body">
                                    <input type="hidden" name="upload_excel_sheet" value="true">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <input type="file" name="excel_file" class="file-input-custom-excel" data-show-caption="false" data-show-upload="false">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="file" name="image_files[]" class="file-input-custom" data-show-caption="false" accept="image/*" data-show-upload="false" data-fouc multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="/sample/sample.xlsx" class="btn btn-light btn-block btn-float m-0">
                    <i class="icon-download10 text-success-400 icon-2x"></i>
                    <span>Sample Download</span>
                </a>
            </div>
        </div>
    </div>
    </div>

    </div>
    <!-- /highlighting rows and columns -->

    <!-- Left content -->
    <div class="w-100">
        <!-- Grid -->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <div class="row mb-3">
                    <form action="{{ route('admin.select_category') }}" method="GET" id="get_items" class="d-flex align-items-center">
                        <select name="per_page" id="per_page" class="form-control col-md-3">
                            <option value="10" @if($per_page == 10)selected @endif>10</option>
                            <option value="20" @if($per_page == 20)selected @endif>20</option>
                            <option value="30" @if($per_page == 30)selected @endif>30</option>
                        </select>
                        <span class="text text-nowrap ml-3">items per page</span>
                        <input type="text" id="search" name="search" class="form-control ml-4 col-md-8" value="{{$search}}" placeholder="input item name to search" />
                        <input type="hidden" name="category_id" id="category_id" value="{{$category_id}}" />
                        <input type="submit" value="get items" class="form-control btn btn-sm btn-info text text-uppercase ml-4" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 border border-default bg-light p-2">
                <div class="nav flex-column nav-pills text-left" id="v-pills-tab-categories" role="tablist" aria-orientation="vertical">
                    @foreach($categories as $k => $cat_item)
                    <a class="nav-link @if($cat_item->id == $category_id)active @endif text-uppercase" id="v-pills-{{$cat_item->id}}-tab" onclick="get_items('{{$cat_item->id}}')" role="tab">{{$cat_item->name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-10">
                @include('admin.inventory.includes.items_list')
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function get_items(category_id) {
            $('#category_id').val(category_id)
            $('#get_items').submit()
        }
    </script>
@endsection