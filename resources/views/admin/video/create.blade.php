@extends('admin.layout.base')

@section('title', 'Add Video ')

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
						
						<form action="{{route('admin.video.store')}}" method="POST" enctype="multipart/form-data" role="form">
							{{csrf_field()}}
							
							<div class="form-group">
								<label for="badge" class="col-form-label">@lang('admin.name')</label>
								<input name="video_name" type="text" class="form-control" value="{{ old('video_name') }}">
							</div>
							
							<div class="mb-3">
								<textarea name="description" id="editor-full" rows="4" cols="4">
									<h2>Apollo 11</h2>
									<div class="float-right" style="margin-left: 20px;"><img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg"></div>

									<p><strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="#">Neil Armstrong</a> and <a href="#">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.</p>

									<p class="mb-3">Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to Earth. A third member of the mission, <a href="#">Michael Collins</a>, piloted the <a href="#">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to Earth.</p>

									<h5 class="font-weight-semibold">Technical details</h5>
									<p>Launched by a <strong>Saturn V</strong> rocket from <a href="#">Kennedy Space Center</a> in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of <a href="#">NASA</a>'s Apollo program. The Apollo spacecraft had three parts:</p>
									<ol>
										<li><strong>Command Module</strong> with a cabin for the three astronauts which was the only part which landed back on Earth</li>
										<li><strong>Service Module</strong> which supported the Command Module with propulsion, electrical power, oxygen and water</li>
										<li><strong>Lunar Module</strong> for landing on the Moon.</li>
									</ol>
									<p class="mb-3">After being sent to the Moon by the Saturn V's upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then moved into the Lunar Module and landed in the <a href="#">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar Module and rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="#">Pacific Ocean</a> on July 24.</p>

									<h5 class="font-weight-semibold">Mission crew</h5>

									<table class="table table-bordered" style="width: 100%">
										<thead>
											<tr>
												<th>Position</th>
												<th>Astronaut</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Commander</td>
												<td>Neil A. Armstrong</td>
											</tr>
											<tr>
												<td>Command Module Pilot</td>
												<td>Michael Collins</td>
											</tr>
											<tr>
												<td>Lunar Module Pilot</td>
												<td>Edwin "Buzz" E. Aldrin, Jr.</td>
											</tr>
										</tbody>
									</table>

									Source: <a href="http://en.wikipedia.org/wiki/Apollo_11">Wikipedia.org</a>
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

                <form class="form-horizontal" action="{{route('admin.video.store')}}" method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="badge" class="col-md-12 col-form-label">@lang('admin.name')</label>
                        <div class="col-md-10">
                            <select name="designation_id[]" class="form-control" id="badge" multiple>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="video" class="col-md-12 col-form-label">Video</label>
                        <div class="col-md-10">
                            <input type="file" accept="video/mp4" name="video" class="dropify form-control-file" id="video" aria-describedby="fileHelp">
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
            $('#badge').select2();
        })
    </script>
@endsection

