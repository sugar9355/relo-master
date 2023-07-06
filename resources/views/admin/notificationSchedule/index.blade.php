@extends('admin.layout.base')

@section('title', 'Notification Schedules ')

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h5 class="mb-1">
                    Notification Schedules
                </h5>
                <a href="{{ route('admin.notification_schedule.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Notification Schedule</a>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>Days</th>
                        <th>@lang('admin.message')</th>
                        <th>@lang('admin.status')</th>
                        <th>SMS</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notificationSchedules as $index => $notificationSchedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notificationSchedule->days }}</td>
                            <td>{{ $notificationSchedule->message }}</td>
                            <td>{{ $notificationSchedule->status }}</td>
                            <td>{{ ($notificationSchedule->sms) ? 'True' : 'False' }}</td>
                            <td>{{ ($notificationSchedule->email) ? 'True' : 'False' }}</td>
                            <td>
                                <form action="{{ route('admin.notification_schedule.destroy', $notificationSchedule->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('admin.notification_schedule.edit', $notificationSchedule->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>Days</th>
                        <th>@lang('admin.message')</th>
                        <th>@lang('admin.status')</th>
                        <th>SMS</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
