@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;

    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .c_btn {
        font-size: 12px;
        margin-bottom: 3px;
        text-align: left;
        padding: 2px 5px;
    }

    .today {
        background-color: #5cb85c;
        padding: 2px 10px 2px 10px;
        color: white;
        font-size: 12px;
        margin-left: 10px;
    }

    .color {
        width: 120px;
        height: 35px;
    }
</style>
@endsection

@section('content')

<!-- Switchery and card controls -->

<div class="card">
    <div class="card-header bg-indigo-800 header-elements-sm-inline">
        <h6 class="card-title">Shuffle Peak Factor</h6>
        <div class="header-elements">
            <div class="d-flex justify-content-between">

                <div class="list-icons ml-3">
                    <form action="{{ route('admin.shufflepeakfactor.index') }}" method="POST" enctype="multipart/form-data"
                        class="w-100">

                        {{ csrf_field() }}

                        <button type="submit" name="btn_last" value="{{ $c_date['last_date'] }}"
                            class="btn btn-light btn-sm"><i class="icon-arrow-left15"></i></button>
                        <button type="submit" name="btn_next" value="{{ $c_date['next_date'] }}"
                            class="btn btn-light btn-sm"><i class="icon-arrow-right15"></i></button>

                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#demand">Demand</button>

                        <!-- Modal -->
                        <div id="demand" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header bg-teal-400 text-white">
                                        <h4 class="modal-title">Customer Demand</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <table>
                                        @foreach ($CustomerDemand as $c)
                                        <tr>
                                            <td><span class="badge badge-danger">{{$c->demand_name}}</span></td>
                                            <td><input data-id="{{$c->id}}" value="{{$c->min}}" class="form-control min"></td>
                                            <td><input data-id="{{$c->id}}" value="{{$c->max}}" class="form-control max"></td>
                                            <td><input data-id="{{$c->id}}" value="{{$c->color}}" class="form-control color" type="color"></td>
                                        </tr>
                                        @endforeach
                                        </table>
                                    </div>
                                    <input type="hidden" name="demands" id="demands" />
                                    <div class="modal-footer">
                                        <button type="submit" name="btn_customer_demand" value="true"
                                            class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.shufflepeakfactor.store') }}" method="post" enctype="multipart/form-data" class="w-100">
        {{ csrf_field() }}
        <input name="month" value="{{$c_date['now_month']}}" type="hidden">
        <input name="year" value="{{$c_date['now_year']}}" type="hidden">
        <div class="card-body">

            <div class="row">

                <div class="col-md-9">
                    <h6>{{$c_date['now_month_text']}} {{$c_date['now_year']}}</h6>
                </div>

            </div>

            <div class="table-responsive mt-2">

                <table class="table table-bordered">
                    <tr>
                        <th id="1" class="text-center">MON</th>
                        <th id="2" class="text-center">TUE</th>
                        <th id="3" class="text-center">WED</th>
                        <th id="4" class="text-center">THU</th>
                        <th id="5" class="text-center">FRI</th>
                        <th id="6" class="text-center">SAT</th>
                        <th id="7" class="text-center">SUN</th>
                    </tr>

                    @foreach ($calendar[$c_date['now_month']] as $k =>$week)

                    <tr>
                        @foreach($week as $day)
                        <td>{{ ($day ? $day : '&nbsp;') }}
                            @if($c_date['now_month'] == intval(date("m")) && $day == date("d")) <span
                                class="today"><i>Today</i></span>@endif
                            <br>
                            @if($day > 0)
                            <div class="row">
                                <input name="peak[{{$c_date['now_month']}}][{{$day}}][0]" value="{{ $peakFactor1[$day] or 0 }}"
                                    class="form-control text-center col-6">
                                <input name="peak[{{$c_date['now_month']}}][{{$day}}][1]" value="{{ $peakFactor2[$day] or 0 }}"
                                    class="form-control text-center col-6">
                            </div>
                            @endif
                        </td>
                        @endforeach
                    </tr>

                    @endforeach
                </table>


            </div>
        </div>

        <div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center">

            <div class="mt-2 mt-sm-0">
                <button type="submit" name="btn_submit" value="true" class="btn bg-indigo-400"><i
                        class="icon-checkmark3 mr-2"></i> Save</button>
                <button type="button" class="btn btn-light ml-1"><i class="icon-cross2 mr-2"></i> Close</button>
            </div>
        </div>
    </form>
</div>

<!-- /switchery and card controls -->
@endsection
@section ('scripts')
<script src=""></script>
<script>
    var demands = {
    @foreach ($CustomerDemand as $c)
        "{{$c->id}}": { "id": "{{ $c->id }}", "min": "{{ $c->min }}", "max": "{{ $c->max }}", "color": "{{$c->color}}" }, 
    @endforeach
    };
    $('#demands').val(JSON.stringify(demands))
    console.log($('#demands').val())

    $(".min").keyup(function() {
        var id = $(this).data('id');
        demands[id].min = $(this).val();
        $('#demands').val(JSON.stringify(demands))
        console.log($('#demands').val())
    })
    $(".max").keyup(function() {
        var id = $(this).data('id');
        demands[id].max = $(this).val();
        $('#demands').val(JSON.stringify(demands))
    })
    $(".color").change(function() {
        var id = $(this).data('id');
        demands[id].color = $(this).val();
        $('#demands').val(JSON.stringify(demands))
    })

</script>
@endsection