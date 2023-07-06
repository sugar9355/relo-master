@extends('admin.layout.base')

@section('title', 'Email Logs')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h5 class="mb-1">
                    @lang('admin.include.logs')
                </h5>
                @if(isset($logs) && $logs)
                    <table class="table table-striped table-bordered dataTable" id="table-2">
                        <thead>
                        <tr>
                            <th>@lang('admin.sr')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.message')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($logs as $log)
                            <tr>
                                <td> {{ $i++ }} </td>
                                <td> {{ $log->email }} </td>
                                <td> {{ $log->message }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>@lang('admin.sr')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.message')</th>
                        </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
