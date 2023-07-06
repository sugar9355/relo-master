@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
	<style>
		.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end{
			border-color: transparent !important;
			background-color: transparent !important;
		}
		.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end{
			border: none;
			background: none;
		}
		.boxex{
			border-radius: 5px;
			padding: 10px 5px 5px;
			font-size: 10px
		}
		.one{
			padding: 0 7px 3px;
			border-radius: 3px;
			margin-left: 30px;
		}
		.first-icon{
			margin-top: -9px;
			margin-left: 67px;
			font-size: 7px;
		}
		.second-icon{
			margin-left: 67px;
			font-size: 7px;
		}
	</style>
@endsection

@section('content')

	<div class="card">
		<div class="card-body">
			<div class="row row-md">
				<div class="col-lg-2 col-md-4 col-xs-6">
					<div class="box box-block bg-white tile tile-1 mb-2">
						<div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
						<div class="t-content">
							<h1 class="mb-1">{{$all}}</h1>
							<h6 class="text-uppercase">@lang('admin.dashboard.Rides')</h6>
							
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-xs-6">
					<div class="box box-block bg-white tile tile-1 mb-2">
						<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
						<div class="t-content">
							<h1 class="mb-1">{{$pending}}</h1>
							<h6 class="text-uppercase">@lang('admin.dashboard.Revenue')</h6>
							
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-xs-6">
					<div class="box box-block bg-white tile tile-1 mb-2">
						<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
						<div class="t-content">
							<h1 class="mb-1">{{$unAssigned}}</h1>
							<h6 class="text-uppercase">@lang('admin.dashboard.service')</h6>
							
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-xs-6">
					<div class="box box-block bg-white tile tile-1 mb-2">
						<div class="t-icon right"><span class="bg-warning"></span><i class="ti-archive"></i></div>
						<div class="t-content">
							<h1 class="mb-1">{{$assigned}}</h1>
							<h6 class="text-uppercase">@lang('admin.dashboard.total_rides')</h6>
							
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-xs-6">
					<div class="box box-block bg-white tile tile-1 mb-2">
						<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
						<div class="t-content">
							<h1 class="mb-1">{{$completed}}</h1>
							<h6 class="text-uppercase">@lang('admin.dashboard.rides')</h6>
							
						</div>
					</div>
				</div>
			</div>
			<div class="row row-md">
				
			</div>
			{{--<div class="row">
				<div class="col-md-3">
					<button class="btn btn-block" style="border: 1px solid red">All</button>
				</div>
				<div class="col-md-3">
					<button class="btn btn-block">Assigned</button>
				</div>
				<div class="col-md-3">
					<button class="btn btn-block">Un Assigned</button>
				</div>
				<div class="col-md-3">
					<button class="btn btn-block">Pedding</button>
				</div>
			</div>--}}

			<div id="calender">
			</div>

		</div>
	</div>

	<script>
		$(function() {
			/*try{
				$('[data-toggle="popover"]').popover({
					trigger: 'hover',
				});
			}catch (e) {
				console.log(e);
			}*/
			$('#calender').fullCalendar({
				eventSources: [
					{
						url: '{{ route('admin.getAllEvents') }}', // use the `url` property
						color: 'yellow',    // an option!
						textColor: 'black'  // an option!
					}
				],
				editable: true,
				eventDurationEditable:false,
				eventRender:function(eventObj, $el) {
					let title = $el.find( '.fc-title' );
					title.html( title.text() );
				},
				eventDrop: function(data, duration){
					let id = data.id;
					let date = data.start.format("YYYY-MM-DD");
					$.ajax({
						url: "/admin/update_date/"+id+"/"+date,
						success: function(result){
							console.log(result);
						}
					});
				},
				eventClick: function(calEvent, jsEvent, view) {
					let url = `/admin/${calEvent.endpoint}/${calEvent.id}/edit`;
					window.open(url, '_blank');
				}
			});
		});
	</script>
@endsection
