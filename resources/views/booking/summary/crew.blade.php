<div class="workers">
    <div class="wor-fon btnn btn2 @if($booking->crew_count == 1) act @endif" onclick="update_crew(1)" id="man1">
        @if (in_array(1, $rec_nums))
        <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>
        @endif
        <div class="">1 worker</div>
        <img src="{{asset('asset/img/preview-imgs/icon_one_p.png')}}">
    </div>
    <div class="wor-fon btnn btn2 @if($booking->crew_count == 2) act @endif" onclick="update_crew(2)" id="man2">
        @if (in_array(2, $rec_nums))
        <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>
        @endif
        <div class="wor-fon ">2 workers</div>
        <img src="{{asset('asset/img/preview-imgs/icon_two_p.png')}}">
    </div>
    <div class="wor-fon btnn btn2 @if($booking->crew_count == 3) act @endif" onclick="update_crew(3)" id="man3">
        @if (in_array(3, $rec_nums))
        <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>
        @endif
        <div class="wor-fon">3 workers</div>
        <div>
            <img src="{{asset('asset/img/preview-imgs/icon_one_p.png')}}">
            <img src="{{asset('asset/img/preview-imgs/icon_two_p.png')}}">
        </div>
    </div>
    <div class="wor-fon btnn btn2 @if($booking->crew_count == 4) act @endif" onclick="update_crew(4)" id="man4">
        @if (in_array(4, $rec_nums))
        <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>
        @endif
        <div class="wor-fon">4 workers</div>
        <div>
            <img src="{{asset('asset/img/preview-imgs/icon_two_p.png')}}">
            <img src="{{asset('asset/img/preview-imgs/icon_two_p.png')}}">
        </div>
    </div>
    <div class="wor-fon btnn btn2 @if($booking->crew_count == 1) act @endif" onclick="update_crew(1)" id="man5">
        @if (in_array(5, $rec_nums))
        <div class="card-header recomended py-0 px-3   text-center bg-warning mb-1 rounded d-block">Recomended</div>
        @endif
        <div class="wor-fon">Truck</div>
        <img src="{{asset('asset/img/preview-imgs/icon_truck.png')}}">
    </div>
</div>
<form action="/update_crew/{{$booking->booking_id}}" method="POST" enctype="multipart/form-data" id="selCrew">
    {{ csrf_field() }}
    <input type="hidden" name="crew" id="crew" />
</form>