<div class="tab-content" id="v-pills-tab-content">
    <div class="tab-pane fade show active" id="item-list-container" role="tabpanel">
        <div class="row">
            @php
                $now = new DateTime();
            @endphp
            @foreach ($inventories as $inventory)
            <div class="col-xl-2 col-sm-3">
                <div class="card">
                    @php
                        $created = new DateTime($inventory->created_at);
                        $diff = date_diff($now, $created);
                    @endphp
                    @if ($inventory->customer_created && $diff->d <= 1)
                        <span class="badge badge-warning">New</span>
                    @endif
                    <div class="card-header bg-white header-elements-sm-inline p-0 pl-1">
                        <span class="card-title"><i class="icon-cube4 text-teal"></i> {{$inventory->volume}} <font size="1">cm3</font></span> 
                        <div class="header-elements">
                            <ul class="nav nav-pills mb-0">
                                <li class="nav-item dropdown dropdown-menu-right">
                                    <a href="#" class="nav-link dropdown-toggle p-0 pt-1 mr-1 pb-1" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-107px, 40px, 0px);">
                                        <a data-toggle="modal" data-target="#upload_{{ $inventory->id }}" class="dropdown-item" tabindex="-1">
                                            <i class="icon-upload text-success"></i>
                                            Upload image
                                        </a>
                                        <a href="{{ route('admin.inventory.edit', $inventory->id) }}" class="dropdown-item" tabindex="-1">
                                            <i class="icon-pencil text-primary"></i>
                                            @lang('admin.edit')
                                        </a>
                                        <a href="#card-pill4" class="dropdown-item" tabindex="-1" data-toggle="modal" data-target="#delete_{{ $inventory->id }}" data-toggle="tab">
                                            <i class="icon-trash text-danger"></i>
                                            @lang('admin.delete')
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-img-actions">
                            @if($inventory->file_path == '')
                            <a href="/no_item.jpg" data-popup="lightbox">
                                <img src="/no_item.jpg" class="card-img" width="80" height="100" alt="">
                                <span class="card-img-actions-overlay card-img">
                                    <i class="icon-zoomin3"></i>
                                </span>
                            </a>
                            @else
                            <a href="{{$inventory->file_path}}" data-popup="lightbox">
                                <img src="{{$inventory->file_path}}" class="card-img" width="80" height="100" alt="">
                                <span class="card-img-actions-overlay card-img">
                                    <i class="icon-zoomin3"></i>
                                </span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body bg-light text-center pt-1 pb-0">
                        <div class="mb-2">
                            <h6 class="font-weight-semibold mb-0">
                                <a href="#" class="text-default">{{ ucfirst($inventory->name) }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="delete_{{ $inventory->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title">Are You Sure ?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body  text-center p-0">
                            <hr>
                            Do you want to delete Selected Row ?
                            <hr>
                        </div>
                        <div class="modal-footer">
                            <form class="m-0" action="{{ route('admin.inventory.destroy', $inventory->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-success" >Yes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="upload_{{ $inventory->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title">Upload Picture</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body pt-0 pb-0">
                            <hr>
                            <form class="m-0" action="/admin/image_upload/{{ $inventory->id }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="file" name="file" class="file-input-custom" data-show-caption="true" data-show-upload="true" accept="image/*" data-focus>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @include('admin.inventory.includes.items_list_pagination')
    </div>
</div>