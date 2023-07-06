	<div class="progress"  style="height:100px">

		<div style="width:{{$booking->minutes}}%" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
			Hub Travel Time <br> {{$booking->minutes}} mins <br> <i class="fa fa-truck fa-3x fa-flip-horizontal" aria-hidden="true"></i>
		</div>

		<div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{$item_load_time}}%">
			Location A <br> Loding Time <br> {{$item_load_time}} mins <br>
		
			<!-- Trigger the modal with a button -->
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">View Items</button>

			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				  </div>
				  <div class="modal-body">
					<table class="table table-striped table-bordered">
						
							
							<?php
							foreach($items as $key => $itm_v)
							{?> <tr><td><?php echo $key+1; ?></td><td><?php echo $itm_v->name; ?></td><td><img src="/default.png" class="img-fluid"></td></tr>
							<?php } ?>
							
						
					</table>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>

			  </div>
			</div>
		</div>
		
		<div style="width:{{$booking->minutes + $total_time}}%" class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
			<font size="2">Travel Time A to B </font> <br> {{$booking->minutes}} mins <br>
			
			<i class="fa fa-truck fa-3x fa-flip-horizontal" aria-hidden="true"></i>
			
		</div>
		
		<div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{$item_Unload_time}}%">
			Location B <br> Loding Time <br> {{$item_Unload_time}} mins <br>
			
			<!-- Trigger the modal with a button -->
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">View Items</button>
		
		</div>
		
	</div>