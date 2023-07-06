<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="vol_{{ $item->id }}" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Inventory Item Volume </h4>
</div>
<div class="modal-body">
<center><p>{{ $item->width }} * {{  $item->height }} * {{  $item->breadth }}  = {{  $item->volume }} <strong>cm3</strong></p></center>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>

