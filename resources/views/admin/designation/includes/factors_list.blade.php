<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



<!-- Trigger the modal with a button -->
<button type="button" style="margin-left: 1em;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#factors_list">Factors list</button>

<!-- Modal -->
<div id="factors_list" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Badges Factors</h4>
  </div>
  <div class="modal-body">
  
	<ul class="nav nav-tabs">
	@foreach ($badge_types as $key => $type)
        <li><a data-toggle="tab" href="#{{$type->badge_type_id}}">{{$type->badge_type_name}}</a></li>
    @endforeach
	</ul>
	
	<div class="tab-content">
	@foreach ($badge_types as $key => $type)
	<div id="{{$type->badge_type_id}}" class="tab-pane fade in @if($key == 0) active @endif">
	
			<table class="table table-striped table-bordered">	
				
				<tr>
					<th class="text-center">Factor</th>
					<th class="text-center">Amount</th>
					<th class="text-center">Unit</th>
					<th class="text-center">Discription</th>
					<th>Designation</th>
				</tr>
				
			@foreach ($badge_factors as $factor)
				@if ($type->badge_type_id == $factor->badge_type_id)
					
					<tr>
					<td width="15%" class="align-middle text-center p-0">
						{{$factor->factor_name}}
					</td>
					<td class="align-middle text-center">
						{{ $factor->factor_value }}
					</td>
					<td class="align-middle text-center">
						{{ $factor->factor_unit }} 
					</td>
					<td class="align-middle">
						{!!$factor->factor_description!!}
					</td>
					<td class="align-middle">
						@foreach ($roles as $k => $role)
							
							@if($role->id == $factor->role_A || $role->id == $factor->role_B || $role->id == $factor->role_C)
							{{ $role->name }}<br>
							@endif
							
						@endforeach			
					</td>
				</tr>
					
					
				@endif		
			@endforeach
				</table>
	</div>
	@endforeach
	</div>
	
  </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>

