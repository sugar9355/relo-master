<h3 class="form-section2 alert-info">Time Factors</h3>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		
			<label class="control-label col-md-6">Distance Time</label>
			<div class="col-md-6">
				<p class="form-control-static"> {{ $request->minutes }} Minutes </p>
			</div>
			
			<label class="control-label col-md-6">Stair Time</label>
			<div class="col-md-6">
				<p class="form-control-static"> {{ $avg_time }} Minutes </p>
			</div>
			
			<label class="control-label col-md-6">Stair Type Time</label>
			<div class="col-md-6">
				<p class="form-control-static"> {{ $stair_time }} Minutes </p>
			</div>
			
			<label class="control-label col-md-6">Ranking Time</label>
			<div class="col-md-6">
				<p class="form-control-static"> {{ $ranking_time }} Minutes </p>
			</div>
			<div class="col-md-12">
				<hr>
			</div>
			
			<label class="control-label col-md-6">Total Time</label>
			<div class="col-md-6">
				<p class="form-control-static"> {{ $request->exp_end_time }} </p>
			</div>
			
		</div>
	</div>
	<!--/span-->
   
</div>