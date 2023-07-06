@extends('admin.layout.base')

@section('title', 'Update Promocode ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
    	    <a href="{{ route('admin.promocode.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.promocode.update_promocode')</h5>

            <form class="form-horizontal" action="{{route('admin.promocode.update', $promocode->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label for="promo_code" class="col-md-2 col-form-label">@lang('admin.promocode.promocode')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $promocode->promo_code }}" name="promo_code" required id="promo_code" placeholder="Promocode">
					</div>
				</div>

				<div class="form-group">
					<label for="discount" class="col-md-2 col-form-label">@lang('admin.promocode.discount')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ $promocode->discount }}" name="discount" required id="discount" placeholder="Discount">
					</div>
				</div>

				<div class="form-group">
					<label for="discount" class="col-md-2 col-form-label">@lang('admin.promocode.discount_type')</label>
					<div class="col-md-10">
						<select class="form-control" name="discount_type" required id="discount_type">
						<option value="percent" @if($promocode->discount_type=='percent') selected @endif >In Percentage Mode(%)</option>
						<option value="amount" @if($promocode->discount_type=='amount') selected @endif >In Amount Mode</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="expiration" class="col-md-2 col-form-label">@lang('admin.promocode.expiration')</label>
					<div class="col-md-10">
						<input class="form-control" type="date" value="{{ date('Y-m-d',strtotime($promocode->expiration)) }}" name="expiration" required id="expiration" placeholder="Expiration">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-2 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.promocode.update_promocode')</button>
						<a href="{{route('admin.promocode.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
