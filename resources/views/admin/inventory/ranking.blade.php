<div class="col-md-10"><hr></div>

<div class="form-group row m_b">
	
		<div class="col-md-5">
			<label for="" class="col-form-label">Ranking for disassembly on the inventory level</label>
		</div>	
		<div class="col-md-5">
			<label for="" class="col-form-label">Time Required for disassembly on the selected inventory level ? </label>
		</div>	
	
</div>


<div class="form-group row m_b">
	
		<div class="col-md-12">
		
			<div class="col-md-5">
			@if(isset($ranking) && !empty($ranking))
			@foreach($ranking as $key => $val)
				<div class="col-md-12">
					<label for="" class="col-form-label">{{$val->alphabet}} - {{$val->ranking_name}}</label>
				</div>	
			@endforeach
			@endif				
			</div>	
		
			
			<div class="col-md-2">
				<div class="col-md-12">
					<input class="form-control" type="number" name="R_A" required id="R_A" placeholder="Ranking Time of Selected Inventory Item"  value="{{ $inventory->R_A }}">
				</div>		
				<div class="col-md-12">
					<input class="form-control" type="number" name="R_B" required id="R_B" placeholder="Ranking Time of Selected Inventory Item"  value="{{ $inventory->R_B }}">
				</div>		
				<div class="col-md-12">
					<input class="form-control" type="number" name="R_C" required id="R_C" placeholder="Ranking Time of Selected Inventory Item"  value="{{ $inventory->R_C }}">
				</div>		
				<div class="col-md-12">
					<input class="form-control" type="number" name="R_D" required id="R_D" placeholder="Ranking Time of Selected Inventory Item"  value="{{ $inventory->R_D }}">
				</div>		
				<div class="col-md-12">
					<input class="form-control" type="number" name="R_E" required id="R_E" placeholder="Ranking Time of Selected Inventory Item"  value="{{ $inventory->R_E }}">
				</div>		
			</div>	
			<div class="col-md-5"></div>	
		</div>
	
</div>

<div class="col-md-10"><hr></div>
