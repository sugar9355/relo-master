<form action="{{ route('store.storage.return', $id) }}" method="post" id="itemForm">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Item Details</h4>
            </div>
            <div class="modal-body">
                @foreach($items as $item)
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-4 myLabel">{{ $item->name }}</div>
                                <div class="col-md-4 myLabel">1</div>
                                <div class="col-md-4 myLabel">{{ json_decode($item->options)->drop }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="submitMyModalForm()" data-dismiss="modal">Get Return To Destinations</button>
            </div>
        </div>

    </div>
</form>
