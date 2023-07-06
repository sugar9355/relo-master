@extends('admin.layout.base')

@section('title', 'Shuffle Fees ')

@section('styles')
<style>
    strong {
        font-size: 15px;
        letter-spacing: 0.2px;
    }
</style>
@endsection

@section('content')
<div class="card-group-control card-group-control-right" id="accordion">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Shuffle Fees</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <form class="form-horizontal" action="{{route('admin.shuffle_fee.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group col-md-12">
                            <label for="base_rate"><strong>Base Rate</strong></label>
                            <input class="form-control" name="base_rate" id="base_rate" type="number" value="{{isset($shuffle_fees->base_rate) ? $shuffle_fees->base_rate : 0}}" step="0.01" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="charge_cb_ft"><strong>Charge per cb ft</strong></label>
                            <input class="form-control" name="charge_cb_ft" id="charge_cb_ft" type="number" value="{{isset($shuffle_fees->charge_cb_ft) ? $shuffle_fees->charge_cb_ft : 0}}" step="0.01" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="curbside_fee"><strong>Curbside Fees</strong></label>
                            <input class="form-control" name="curbside_fee" id="curbside_fee" type="number" value="{{isset($shuffle_fees->curbside_fee) ? $shuffle_fees->curbside_fee : 0}}" step="0.01" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="curbside_fee"><strong>Survival Kit</strong></label>
                            <input class="form-control" name="survival_kit" id="survival_kit" type="number" value="{{isset($shuffle_fees->survival_kit) ? $shuffle_fees->survival_kit : 0}}" step="0.01" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="curbside_fee"><strong>Supplies Kit</strong></label>
                            <input class="form-control" name="supplies_kit" id="supplies_kit" type="number" value="{{isset($shuffle_fees->supplies_kit) ? $shuffle_fees->supplies_kit : 0}}" step="0.01" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="parking_situations"><strong>Parking Situation</strong></label>
                            @php
                                $parking_situations = array();
                                if (isset($shuffle_fees->parking_situations))
                                    $parking_situations = explode(',', $shuffle_fees->parking_situations);
                            @endphp
                            <select name="parking_situations[]" id="parking_situations" class="form-control select" multiple>
                                @foreach ($parking_times as $p)
                                <option value="{{$p->id}}" @if(in_array($p->id, $parking_situations))selected @endif>{{$p->parking}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @php
                            $parking_fees = array();
                            if (isset($shuffle_fees->parking_fees))
                                $parking_fees = json_decode($shuffle_fees->parking_fees, true);
                        @endphp
                        @foreach ($parking_times as $p)
                        <div class="form-group col-md-12 p_field" id="p_field_{{$p->id}}" @if(!in_array($p->id, $parking_situations))style="display: none" @endif>
                            <label for="parking_fees_{{$p->id}}"><strong>Flat Fee ({{$p->parking}})</strong></label>
                            <input class="form-control col-md-6" type="number" name="parking_fees[{{$p->id}}]" id="parking_fees_{{$p->id}}"
                                value="{{isset($parking_fees[$p->id]) ? $parking_fees[$p->id] : null}}" step="0.01" />
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label for="" class="ml-2"><strong>Long Walks</strong></label>
                        @php
                            $vol_mins = $vol_maxs = $long_walk_fees = array();
                            $count = 0;
                            if (isset($shuffle_fees->vol_min))
                                $vol_mins = json_decode($shuffle_fees->vol_min, true);
                            if (isset($shuffle_fees->vol_max))
                                $vol_maxs = json_decode($shuffle_fees->vol_max, true);
                            if (isset($shuffle_fees->long_walk_fee))
                                $long_walk_fees = json_decode($shuffle_fees->long_walk_fee, true);
                            $count = count($long_walk_fees);
                        @endphp
                        <div class="form-group ml-2 pl-2" id="long_walks_field">
                            @if ($count != 0)
                            @foreach ($long_walk_fees as $k => $lw_fee)
                            <div class="row @if($k != 0)l_w_field_{{$k}} mt-3 @endif">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Min(Volume)</label>
                                        <input class="form-control" type="number" id="vol_min_{{$k}}" name="vol_min[{{$k}}]" value="{{$vol_mins[$k]}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Max(Volume)</label>
                                        <input class="form-control" type="number" id="vol_max_{{$k}}" name="vol_max[{{$k}}]" value="{{$vol_maxs[$k]}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Fee</label>
                                        <input class="form-control" type="number" id="long_walk_fee_{{$k}}" name="long_walk_fee[{{$k}}]" value="{{$lw_fee}}">
                                    </div>
                                </div>
                                @if ($k == 0)
                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="btn_add" type="button" class="btn btn-success" value="{{$count}}">Add More</button>
                                </div>
                                @else
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger" onclick="remove({{$k}})">Remove</button>
                                </div>
                                @endif
                            </div>
                            @endforeach
                            @else
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Min(Volume)</label>
                                        <input class="form-control" type="number" id="vol_min_0" name="vol_min[0]" value="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Max(Volume)</label>
                                        <input class="form-control" type="number" id="vol_max_0" name="vol_max[0]" value="100">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Fee</label>
                                        <input class="form-control" type="number" id="long_walk_fee_0" name="long_walk_fee[0]" value="0">
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="btn_add" type="button" class="btn btn-success" value="0">Add More</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="mb-2"><strong>Dis-assembly and Assembly Flat Fee</strong></label>
                        @php
                            $dis_assem_fees = array();
                            if (isset($shuffle_fees->dis_assem_fee))
                                $dis_assem_fees = json_decode($shuffle_fees->dis_assem_fee, true);
                        @endphp
                        @foreach ($ranking as $item)
                        <div class="form-group col-md-12">
                            <label for="dis_assem_fee_{{$item->ranking_id}}">{{$item->alphabet}} - {{$item->ranking_name}}</label>
                            <input class="form-control col-md-6" name="dis_assem_fee[{{$item->ranking_id}}]" id="dis_assem_fee_{{$item->ranking_id}}" type="number"
                                value="{{isset($dis_assem_fees[$item->ranking_id]) ? $dis_assem_fees[$item->ranking_id] : null}}" step="0.01" />
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <hr>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane"></i></button>
                        <a href="{{route('admin.shuffle_fee.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Theme JS files -->    
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<!-- /theme JS files -->
<script>
    jQuery(document).ready(function() {
        $('#parking_situations').change(function() {
            var selected = $(this).val();
            $('.p_field').hide();
            selected.map(function(p_id) {
                $('#p_field_' + p_id).show();
            })
        })

        $('#btn_add').click(function() {
            var index = parseInt($(this).val());
            $(this).val(index + 1);
            var res = '<div class="row mt-3 l_w_field_' + index + '"><div class="col-md-3">';
            res += '<div class="form-group"><label for="">Min(Volume)</label>';
            res += '<input class="form-control" type="number" id="vol_min_' + index + '" name="vol_min[' + index + ']">';
            res += '</div></div><div class="col-md-3">';
            res += '<div class="form-group"><label for="">Max(Volume)</label>';
            res += '<input class="form-control" type="number" id="vol_max_' + index + '" name="vol_max[' + index + ']">';
            res += '</div></div><div class="col-md-3">';
            res += '<div class="form-group"><label for="">Fee</label>';
            res += '<input class="form-control" type="number" id="long_walk_fee_' + index + '" name="long_walk_fee[' + index + ']">';
            res += '</div></div><div class="col-md-3 d-flex align-items-end">';
            res += '<button type="button" class="btn btn-danger" onclick="remove(' + index + ')">Remove</button></div></div>';

            $('#long_walks_field').append(res);
        })
    })

    function remove(index) {
        $('.l_w_field_' + index).remove();
    }
</script>
@endsection
