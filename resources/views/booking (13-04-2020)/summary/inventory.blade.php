<div class="card mt-3">
<div class="card-header bg-dark text-white">
<div class="row">
<div class="col-md-6">
  <h3 class="m-0 font-weight-normal"><i class="fas fa-boxes mr-2"></i> Inventory Items</h3>
</div>
<div class="col-md-6 text-right">
  <form action="" class="d-inline-flex text-right">
	<div class="btn btn-outline-light mr-md-2">Packaging</div>
	<div class="btn btn-outline-light mr-md-2">Junk</div>
	<div class="input-group">
	<input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
	<div class="input-group-append">
	  <button class="btn btn-outline-light" type="button" id="button-addon2"><i class="fa fa-search"></i> Search</button>
	</div>
  </div>
  </form>
</div>
</div>
</div>
<div class="card-body">
<div class="row">
@foreach($selected_items as $k => $added_item )
<div class="col-xl-2 col-sm-3">
  <div class="card">
	<a href="item-1.jpg" class="p-0 m-0 text-center">
	  <img src="{{$added_item->file_path}}" class="card-img-top" width="60" height="80" alt="">
	</a>
	<div class="card-body bg-light text-center p-0">      
	  <small class="py-2 d-block">{{$added_item->item_name}}</small>
	  <div class="btn-group d-block" role="group">
		<form class="m-0 row w-100" id="ajaxform216" action="/booking/162" method="post" enctype="multipart/form-data">
		  <button class="btn btn-warning btn-sm rounded-0 col-3" type="button" data-toggle="modal" data-target="#item_info_216"><i class="far fa-eye" aria-hidden="true"></i></button>
		  <button class="btn btn-dark btn-sm rounded-0 col-3" type="button" data-toggle="modal" data-target="#item_delete216"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
		  <br>
		  <input name="action" onclick="submitform('216','-');" type="submit" class="btn btn-secondary btn-sm fas fa-plus fa-lg rounded-0 col-3" value="-" aria-hidden="true">
		  <input name="action" onclick="submitform('216','+');" type="submit" value="+" class="btn btn-secondary btn-sm fas fa-plus fa-lg rounded-0 col-3 border-right-0" aria-hidden="true">
		</form> 
	  </div>    
	  <div class="w-100 text-center py-1">
		Qty: {{$added_item->quantity}}
	  </div>    
	</div>
  </div>
</div>
@endforeach

</div>
</div>
</div>