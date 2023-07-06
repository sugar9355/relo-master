@extends('admin.layout.base')

@section('title', 'Request details ')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.user_request.index') }}" class="btn btn-default pull-right">
                            <i class="fa fa-angle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="row" style='margin-top: 20px;'>
                    <div class="col-md-12">
                        <h4> Designation: </h4>
                        <ul>
                            @foreach(json_decode($video->designation_id) as $designation_id)
                                <li>{{ \App\Designation::find($designation_id)->name }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                <div class="row" style='margin-top: 20px;'>
                    <div class="col-md-12">
                        <video class="w-100" controls>
                            <source src="{{ asset('uploads/video/'.$video->file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
