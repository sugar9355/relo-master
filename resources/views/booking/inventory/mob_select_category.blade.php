
 @if(isset($presets[0]))
        <form action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            @foreach($presets as $preset)
            @php
            $item_ids = 0;
            $item_ids = explode(',',$preset->item_ids);
            @endphp
            <li> 
            <button type="submit" name="btn_preset" value="{{$preset}}" class="list-group-item list-group-item-action hvr-grow list-group-item-action bg-transparent text-info">
                <i class="fas fa-couch mr-2"></i>
                {{$preset->name}}
               <span class="badge badge-secondary pull-right">{{ count($item_ids) }}</span>
            </button>
            </li>
            
            @endforeach
        </form>
        @endif
                   
                  
                