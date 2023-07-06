@extends('admin.layout.base')

@section('title', 'Edit Video ')

@section('content')

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/editors/ckeditor/ckeditor.js')}}"></script>
	<script src="{{asset('assets_admin/js/demo_pages/editor_ckeditor.js')}}"></script>
	<!-- /theme JS files -->

	
	
	<div class="card">
        <div class="card-body">
		<!-- CKEditor default -->
				<div class="card">
					<div class="card-body">
						
						<form class="form-horizontal" action="{{route('admin.video.update', $video->id)}}" method="POST" enctype="multipart/form-data" role="form">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							
							<div class="form-group">
								<label for="badge" class="col-form-label">@lang('admin.name')</label>
								<input name="video_name" type="text" class="form-control" value="{{ $video->video_name }}">
							</div>
							
							<div class="mb-3">
								<textarea name="description" id="editor-full" rows="4" cols="4">
									{{$video->description}}
					            </textarea>
				            </div>

				            <div class="text-right">
					            <button type="submit" class="btn bg-teal-400">Submit form <i class="icon-paperplane ml-2"></i></button>
				            </div>
			            </form>
					</div>
				</div>
				<!-- /CKEditor default -->
		</div>
    </div>
	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.video.index') }}" class="btn btn-default pull-right"><i
							class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Add Video</h5>

				<form class="form-horizontal" action="{{route('admin.video.update', $video->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					

					<div class="form-group">
						<label for="video" class="col-md-12 col-form-label">Video</label>
						<div class="col-md-4">
							<video class="w-100" controls>
								<source src="{{ asset('uploads/video/'.$video->file) }}" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						</div>
					</div>


					<div class="form-group">
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">Add Video</button>
							<a href="{{route('admin.video.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection


@section('scripts')
	<script>
		$(function () {
			let $badge = $('#badge');
			$badge.select2();
			let val = JSON.parse($("#selectVal").val());
			$badge.val(val).change();
		})
	</script>
@endsection

