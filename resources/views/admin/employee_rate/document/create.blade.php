@extends('admin.layout.base')


@section('content')
 <div class="card">
    <div class="card-body">
        <div >
            <h5 style="margin-bottom: 2em;">Add Provider Document</h5>
             <form action="do_create" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                <div class="form-group">
                    <label for="calculator" class="col-md-12 col-form-label">Select Provider</label>
                    <div class="col-md-10">
                        <select class="form-control" id="provider_id" name="provider_id">
                            @foreach($Providers as $index => $provider)
                                <option value="{{ $provider->id }}">{{ ($provider->first_name . $provider->last_name ) . ' ('.$provider->email.')' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="calculator" class="col-md-12 col-form-label">Select Document</label>
                    <div class="col-md-10">
                        <select class="form-control" id="document_id" name="document_id">
                             @foreach($Documents as $index => $document)
                                <option value="{{ $document->id }}">{{ $document->name }}</option>
                             @endforeach
                        </select>
                    </div>
                </div>

               <div class="form-group">
					<label for="picture" class="col-md-12 col-form-label">Upload Document</label>
					<div class="col-md-10">
						<input type="file" accept="image/*" name="url" class="dropify form-control-file" id="url" aria-describedby="fileHelp">
					</div>
				</div>
				
                <div class="form-group">
					<label for="picture" class="col-md-12 col-form-label">Expires</label>
					<div class="col-md-10">
						<input type="date"  name="expires_at" class="form-control" id="expires_at">
					</div>
				</div>
				
                <div class="form-group">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-3">
                                <a href="../document" class="btn btn-danger btn-block">Cancel</a>
                            </div>
                            <div class="col-md-12 col-sm-6 offset-md-6 col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">Add Provider Document</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection