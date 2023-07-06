<div class="card card-body p-0 bg-light">
    <h5 class="m-3 text-dark">Select Size</h5>
    <div class="list-group overflow-auto">

        @if(isset($presets[0]))
        <form id="choose_preset" action="{{ route('show_chosen_preset', $booking->booking_id) }}" method="POST" enctype="multipart/form-data" style="overflow-x: hidden">
            {{ csrf_field() }}
            <input type="hidden" id="preset" name="preset" value="" />

            @foreach($presets as $k => $preset)
            @php
            $item_ids = 0;
            $item_ids = explode(',',$preset->item_ids);
            @endphp

            <button type="button" value="{{$preset}}" class="btn_preset list-group-item list-group-item-action hvr-grow list-group-item-action bg-transparent text-info">
                <i class="fas fa-couch mr-2"></i>
                {{$preset->name}}
                <span class="badge bg-warning float-right text-white">{{ count($item_ids) }}</span>
            </button>
            
            @endforeach
        </form>
        @endif

    </div>

</div>


