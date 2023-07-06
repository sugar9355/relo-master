<!-- Modal -->
<div id="bonus" class="modal fade" role="dialog">
  <div class="modal-dialog">
  
	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Bonus Details</h4>
	  </div>
	  <div class="modal-body">
	  <? //print_r($ref_detail); ?>
		<table class="table table-bordered" >
		<thead> <tr>	
				<td><strong>Refer User Name</strong></td>
				<td><strong>Refer User Hours</strong></td>
				<td><strong>Refer Bonus</strong></td>
				<td><strong>Profile</strong></td>
				
				</tr></thead>
		<tbody>
		@if(!empty($ref_detail))
		
		@foreach($ref_detail as $refer)
		
			<tr>
				<td>@if(isset($refer['refer_user'])){{$refer['refer_user']}}@endif</td>
				<td>@if(isset($refer['hours'])){{$refer['hours']}}@endif</td>
				<td>
					@if(isset($refer['bonus']))
						{{$refer['bonus']}}
					@else
						
					@endif
				</td>
				<td>
					<a href="{{ route('admin.provider.edit', $refer['refer_user_id']) }}" class="btn btn-link">View</a>
				</td>
			</tr>
			
		@endforeach
		@endif
		</tbody>
		</table>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>
