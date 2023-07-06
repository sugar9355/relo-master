
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.box
{
	width:50px;
	height:50px;
}


</style>
<div class="card" id="storage">
	<div class="row">
		<div class="col-md-2">
			<div class="card-body" >
				<div class="draggable box bg-primary rounded"></div>
				<div class="draggable box bg-danger rounded"></div>
			</div>
		</div>	
		<div class="col-md-10 border border-success">	
			<div class="card-body  h-100 droppable">
				
				
			</div>
		</div>
	</div>
</div>


<script>

	$( function() 
	{
		$( ".draggable" ).draggable();
	});

</script>