@foreach($items as $item)
<div class="image inventory-item-mob" id="itemList{{ $item->id }}">
    <div class="card card-body bg-light text-center p-2 mb-3">
        @if($item->file_path == 'saasd')
        <a href="/no_item.jpg" data-popup="lightbox">
            <img src="/no_item.jpg" class="card-img" height="60" alt="">
            <!-- <span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span> -->
        </a>
        
        @else
        {{-- @if($item->ranking_id == null && $item->question == false)
        <form id="frm_add_items{{ $item->id }}" action="/add_item/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}

            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="hidden" name="item_name" value="{{ $item->name }}">
            
            @if(!empty($booking_location))
                @foreach($booking_location as $k => $loc)
                    @if($k == 0)
                    <input type="hidden" name="pick_up_loc_id" value="{{$loc->booking_loc_id}}">
                    @elseif($k == (count($booking_location) - 1))
                    <input type="hidden" name="drop_off_loc_id" value="{{$loc->booking_loc_id}}">
                    @endif
                @endforeach
            @endif
            
            <button type="button" name="btn_submit" onclick="add_item({{ $item->id }});"><img src="{{$item->file_path}}" class="card-img" height="60" alt=""></button>
            
        </form>
        @else --}}
        <span class="close__  close-btn close-btn2 ml-auto cursor rounded-circle d-flex align-items-center justify-content-center close_popup" onclick="deleteItem('{{ $item->id }}')"><i class="icon-close2"></i></span>
        @if($item->file_path == '')
        <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
            <img src="/no_item.jpg" class="card-img" height="60" alt="">
           
        </a>
        @else
        <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
            <img src="{{$item->file_path}}" class="card-img" alt="">
           
        </a>
        @endif
        @endif

        @if (isset($item->preset_quantity))
            <small class="pt-2">{{ ucfirst($item->name) }} - {{$item->preset_quantity}}</small>
        @else
            <small class="pt-2">{{ ucfirst($item->name) }}</small>
        @endif
    </div>
  
</div>

@include('booking.inventory.ranking_add')

@endforeach
