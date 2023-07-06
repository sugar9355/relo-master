<!-- Modal -->
<div id="item_delete{{ $added_item->booking_item_id }}" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h3>{{ $added_item->item_name }}</h3>
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<div class="modal-body">

<div class="border rounded p-3 text-danger text-center">
	<h3>Do you want to remove this from your truck ?<i class="far fa-trash-alt"></i></h3>
</div>

<div class="modal-footer text-center">
	<button type="button" onclick="delete_item('{{ $added_item->booking_id }}','{{ $added_item->booking_item_id }}');" class="btn btn-danger" value="{{ $added_item->booking_item_id }}" data-dismiss="modal">Yes</button>
	<button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">No</button>
</div>

</div>
</div>

</div>
</div>

