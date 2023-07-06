<!-- Modal -->
<div id="item_delete{{ $s_item->booking_item_id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $s_item->item_name }}</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <div class="border rounded p-3 text-danger text-center">
                    <h5>Are you sure do you want to delete this item ? <i class="icon icon-trash"></i></h5>
                </div>

                <div class="modal-footer text-center mt-3">
                    <button type="button" onclick="delete_item('{{ $s_item->booking_id }}','{{ $s_item->booking_item_id }}');" class="btn btn-danger" value="{{ $s_item->booking_item_id }}" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">No</button>
                </div>

            </div>
        </div>

    </div>
</div>
