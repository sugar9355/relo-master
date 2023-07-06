@extends('admin.layout.base')

@section('title', 'Update Role Permission ')

@section('content')

    <div class="card">
        <div class="card-body">
            <div >
                <a href="{{ route('admin.system_user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

                <h5 style="margin-bottom: 2em;">Update Role Permission</h5>

                <form class="form-horizontal" action="{{route('admin.role.assigned', $id )}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="row">
                        @foreach($permissions as $index => $permission)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="permission{{ $index }}" class="col-md-10 col-form-label">{{ $permission->label }}</label>
                                    <div class="col-md-2">
                                        <input type="checkbox" id="permission{{ $index }}"
                                               {{ ($rolePermission->contains('name', $permission->name) ) ? 'checked' : null }}
                                               name="{{ $permission->name }}" value="1">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div style="float: right">
                                <button type="submit" class="btn btn-primary">Update Permission</button>
                                <a href="{{route('admin.role.index')}}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
