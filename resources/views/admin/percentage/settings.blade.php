@extends('admin.layout.base')

@section('title', 'Payment Settings ')

@section('content')

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <div >
                <form action="{{route('admin.settings.percentage.store')}}" method="POST">
                    {{csrf_field()}}
                    <h5>@lang('admin.include.percentage_settings')</h5>
                    <div class="card card-block card-inverse card-primary">
                        <blockquote class="card-blockquote">
                            <div id="card_field">
                                @if($percentageSettings->count() > 0)
                                    @foreach($percentageSettings as $index => $percentageSetting)
                                        <div class="form-group row" id="row_{{ $index }}">
                                            <label for="maximum" class="col-md-1 col-form-label">@lang('admin.payment.max_price')</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text" value="{{ $percentageSetting->max }}" name="max[]" placeholder="Maximum Price" id="maximum">
                                            </div>
                                            <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_percentage')</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text" value="{{ $percentageSetting->percentage }}" name="percentage[]" id="percentage" placeholder="30">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="switch">
                                                    <input type='hidden' value='0' name='is_flat[]' {{ ($percentageSetting->is_flat == 1) ? 'disabled' : null }}>
                                                    <input type="checkbox" value="1" name="is_flat[]" {{ ($percentageSetting->is_flat == 1) ? 'checked' : null }} onclick="toggleDisable(this)">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_flat')</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text" value="{{ $percentageSetting->flat }}" name="flat[]" placeholder="300">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group row" id="row_0">
                                        <label for="maximum" class="col-md-1 col-form-label">@lang('admin.payment.max_price')</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="max[]" placeholder="Maximum Price" id="maximum">
                                        </div>
                                        <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_percentage')</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="percentage[]" id="percentage" placeholder="30">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="switch">
                                                <input type='hidden' value='0' name='is_flat[]'>
                                                <input type="checkbox" value="1" name="is_flat[]" onclick="toggleDisable(this)">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_flat')</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="flat[]" placeholder="300">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="card_btn_field">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button id="btn_add" class="btn btn-info btn-block">Add</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="btn_remove" class="btn btn-danger btn-block">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <a href="{{ route('admin.index') }}" class="btn btn-warning btn-block">@lang('admin.back')</a>
                        </div>
                        <div class="offset-xs-4 col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block">@lang('admin.payment.update_site_settings')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $("#btn_add").on('click', (e) => {
                e.preventDefault();
                let parentSelector = $("#card_field");
                let index = parentSelector[0].children.length;
                let html = `<div class="form-group row" id="row_${index}">
                                <label for="maximum" class="col-md-1 col-form-label">@lang('admin.payment.max_price')</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="max[]" placeholder="Maximum Price" id="maximum">
                                </div>
                                <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_percentage')</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="percentage[]" id="percentage" placeholder="30">
                                </div>
                                <div class="col-md-1">
                                    <label class="switch">
                                        <input type='hidden' value='0' name='is_flat[]'>
                                        <input type="checkbox" value="1" name="is_flat[]" onclick="toggleDisable(this)">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <label for="percentage" class="col-md-2 col-form-label">@lang('admin.payment.upfront_charge_flat')</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="flat[]" placeholder="300">
                                </div>
                            </div>`;
                parentSelector.append(html);
            });

            $("#btn_remove").on('click', (e) => {
                e.preventDefault();
                e.preventDefault();
                let parentSelector = $("#card_field");
                let rows = parentSelector[0].children;
                let length = rows.length;
                if (length === 1){
                    return false;
                }
                $(rows[length-1]).remove();
            })
        });

        function toggleDisable(me) {
            let isChecked = $(me).prop('checked');
            let hiddenField = $(me).parent().find('input[type="hidden"]');
            console.log(hiddenField);
            hiddenField.prop("disabled", false);
            if (isChecked){
                hiddenField.prop("disabled", true);
            }
        }
    </script>
@endsection
