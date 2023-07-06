@extends('admin.layout.base')

@section('title', 'Add Dispute ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
            <a href="#" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

			<h5>Add Dispute</h5>

            <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data" role="form">
				<div class="form-group">
					<label for="first_name" class="col-md-12 col-form-label">Sender Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" placeholder="Sender Name">
					</div>
				</div>
				<div class="form-group">
					<label for="last_name" class="col-md-12 col-form-label">Buyer Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" placeholder="Buyer Name">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-md-12 col-form-label">Problem Type</label>
					<div class="col-md-10">
						<select class="form-control">
							<option>Payment Problem</option>
							<option>Payment Problem</option>
							<option>Payment Problem</option>
							<option>Payment Problem</option>
							<option>Payment Problem</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="zipcode" class="col-md-12 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">Add Dispute</button>
						<a href="#" class="btn btn-danger">Cancel</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
