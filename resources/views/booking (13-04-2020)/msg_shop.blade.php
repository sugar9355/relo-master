@extends('user.layout.app')

@section('content')

	<link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js//plugins/notifications/jgrowl.min.js')}}"></script>
	<script src="{{asset('assets_admin/js//plugins/notifications/noty.min.js')}}"></script>
	<script src="{{asset('assets_admin/js//demo_pages/extra_jgrowl_noty.js')}}"></script>
	<!-- /theme JS files -->

<style>
	.list-group .list-group-item:before{
		background-color: var(--dark);
	}
	.animated {
    -webkit-animation-fill-mode: inherit;
    animation-fill-mode: inherit;
}
</style>


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Extra</span> - jGrowl &amp; Noty</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
						</div>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<a href="extra_jgrowl_noty.html" class="breadcrumb-item">Extra</a>
							<span class="breadcrumb-item active">jGrowl &amp; Noty</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">
							<a href="#" class="breadcrumb-elements-item">
								<i class="icon-comment-discussion mr-2"></i>
								Support
							</a>

							<div class="breadcrumb-elements-item dropdown p-0">
								<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear mr-2"></i>
									Settings
								</a>

								<div class="dropdown-menu dropdown-menu-right">
									<a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
									<a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
									<a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
									<div class="dropdown-divider"></div>
									<a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<!-- Noty notifications -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Noty notifications</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						Noty is a jQuery plugin that makes it easy to create <code>alert</code> - <code>success</code> - <code>error</code> - <code>warning</code> - <code>information</code> - <code>confirmation</code> messages as an alternative the standard alert dialog. The API provides lots of other options to customise the text, animation, speed, buttons and much more. It also has various callbacks for the buttons such as opening and closing the notifications and queue control.
					</div>

					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr class="table-active">
									<th colspan="3">Notification layouts</th>
								</tr>
								<tr>
									<td style="width: 20%;">Error notice</td>
									<td style="width: 20%;">
										<button type="button" class="btn btn-danger" id="noty_error">Launch <i class="icon-play3 ml-2"></i></button>
									</td>
									<td>Error notification. To use, add <code>type: 'error'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Success notice</td>
									<td><button type="button" class="btn btn-success" id="noty_success">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Success notification. To use, add <code>type: 'success'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Warning notice</td>
									<td><button type="button" class="btn btn-warning" id="noty_warning">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Warning notification. To use, add <code>type: 'warning'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Information notice</td>
									<td><button type="button" class="btn bg-blue" id="noty_info">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Info notification. To use, add <code>type: 'info'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Alert notice</td>
									<td><button type="button" class="btn bg-slate-600" id="noty_alert">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Simple alert layout. To use, add <code>type: 'alert'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Confirmation dialog</td>
									<td><button type="button" class="btn btn-light" id="noty_confirm">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Confirmation dialog with buttons and callbacks. To use, add <code>type: 'confirm'</code> option to the notification configuration</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Notification position. Top</th>
								</tr>
								<tr>
									<td>Top position</td>
									<td><button type="button" class="btn btn-light" id="noty_top">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top notification position. To use, add <code>layout: 'top'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Top left position</td>
									<td><button type="button" class="btn btn-light" id="noty_top_left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top left notification position. To use, add <code>layout: 'topLeft'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Top center position</td>
									<td><button type="button" class="btn btn-light" id="noty_top_center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top center notification position. To use, add <code>layout: 'topCenter'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Top right position</td>
									<td><button type="button" class="btn btn-light" id="noty_top_right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top right notification position. To use, add <code>layout: 'topRight'</code> option to the notification configuration</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Notification position. Center</th>
								</tr>
								<tr>
									<td>Center left position</td>
									<td><button type="button" class="btn btn-light" id="noty_center_left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Center left notification position. To use, add <code>layout: 'centerLeft'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Center position</td>
									<td><button type="button" class="btn btn-light" id="noty_center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Center notification position. To use, add <code>layout: 'center'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Center right position</td>
									<td><button type="button" class="btn btn-light" id="noty_center_right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Center right notification position. To use, add <code>layout: 'centerRight'</code> option to the notification configuration</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Notification position. Bottom</th>
								</tr>
								<tr>
									<td>Bottom left position</td>
									<td><button type="button" class="btn btn-light" id="noty_bottom_left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom left notification position. To use, add <code>layout: 'bottomLeft'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Bottom center position</td>
									<td><button type="button" class="btn btn-light" id="noty_bottom_center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom center notification position. To use, add <code>layout: 'bottomCenter'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Bottom right position</td>
									<td><button type="button" class="btn btn-light" id="noty_bottom_right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom right notification position. To use, add <code>layout: 'bottomRight'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Bottom position</td>
									<td><button type="button" class="btn btn-light" id="noty_bottom">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom notification position. To use, add <code>layout: 'bottom'</code> option to the notification configuration</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Other examples</th>
								</tr>
								<tr>
									<td>Overlay</td>
									<td><button type="button" class="btn btn-light" id="noty_overlay">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>To display a dark page overlay when notification is shown, set <code>modal</code> to <code>true</code> in noty config</td>
								</tr>
								<tr>
									<td>Sticky</td>
									<td><button type="button" class="btn btn-light" id="noty_sticky">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Set <code>timeout</code> option to <code>false</code> to disable timer. Progress bar will be also disabled</td>
								</tr>
								<tr>
									<td>Close button</td>
									<td><button type="button" class="btn btn-light" id="noty_close">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>By default, notification is closable on click. To use close button instead, use <code>closeWith: ['button']</code> option</td>
								</tr>
								<tr>
									<td>No progress</td>
									<td><button type="button" class="btn btn-light" id="noty_progress">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Noty's <code>progressBar</code> option displays a progress bar if timeout is not false. Set to <code>false</code> to disable</td>
								</tr>
								<tr>
									<td>Styled</td>
									<td><button type="button" class="btn btn-light" id="noty_styled">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>To use <strong>styled</strong> theme, add <code>  alert alert-danger alert-styled-left p-0</code> classes to <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Styled white</td>
									<td><button type="button" class="btn btn-light" id="noty_styled_white">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>To use <strong>styled</strong> theme with white background, add <code> alert alert-success alert-styled-left p-0 bg-white</code> classes to <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Solid styled</td>
									<td><button type="button" class="btn btn-light" id="noty_solid_styled">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>To use <strong>solid styled</strong> theme, add <code> alert bg-info text-white alert-styled-left p-0</code> classes to <code>theme</code> option</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /noty notifications -->


				<!-- jGrowl notifications -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">jGrowl notifications</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						jGrowl is a pretty flexible and easy to use jQuery plugin that raises unobtrusive messages within the browser, similar to the way that OS X's Growl Framework works. The idea is simple, deliver notifications to the end user in a noticeable way that doesn't obstruct the work flow and yet keeps the user informed. Supports 6 screen positions, 5 contextual color alternatives and various options.
					</div>

					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr class="table-active">
									<th colspan="3">Solid color notifications</th>
								</tr>
								<tr>
									<td style="width: 20%;">Default notice</td>
									<td style="width: 20%;"><button type="button" class="btn btn-primary" id="jgrowl-default">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Basic configuration using <code>theme: 'bg-primary'</code> theme added to the config</td>
								</tr>
								<tr>
									<td>Danger notice</td>
									<td><button type="button" class="btn btn-danger" id="jgrowl-danger">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Danger notification. To use, add <code>theme: 'bg-danger'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Success notice</td>
									<td><button type="button" class="btn btn-success" id="jgrowl-success">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Success notification. To use, add <code>theme: 'bg-success'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Warning notice</td>
									<td><button type="button" class="btn btn-warning" id="jgrowl-warning">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Warning notification. To use, add <code>theme: 'bg-warning'</code> option to the notification configuration</td>
								</tr>
								<tr>
									<td>Info notice</td>
									<td><button type="button" class="btn btn-info" id="jgrowl-info">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Info notification. To use, add <code>theme: 'bg-info'</code> option to the notification configuration</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Basic notification styling</th>
								</tr>
								<tr>
									<td>Default notice</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-alert-default">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Default notification style. To use, add <code>theme: 'alert-*'</code> contextual class to the plugin configuration</td>
								</tr>
								<tr>
									<td>Left icon</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-styled-left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Notification with left icon. To use, add <code>'alert-styled-left'</code> with contextual class to the <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Right icon</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-styled-right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Notification with right icon. To use, add <code>'alert-styled-right'</code> with contextual class to the <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Custom styles</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-custom-styled">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Notification with custom color variations of text, border and background</td>
								</tr>
								<tr>
									<td>Display arrow</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-styled-arrow">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Display arrow. To use, add <code>'alert-arrow-left'</code> or <code>*-right</code> to the <code>theme</code> option</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">Additional styles</th>
								</tr>
								<tr>
									<td>Notice with left icon</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-solid-styled-left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Solid color notification with left icon. To use, add <code>'bg-* alert-styled-left'</code> to the <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Notice with right icon</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-solid-styled-right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Solid color notification with right icon. To use, add <code>'bg-* alert-styled-right'</code> to the <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Custom colors</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-solid-custom-styled">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Alert sith custom styles. To use, add <code>'alert-styled-custom'</code> with other classes to the <code>theme</code> option</td>
								</tr>
								<tr>
									<td>Rounded alert</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-rounded">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Alert with rounded corners. To use, add <code>'alert-rounded'</code> to the <code>theme</code> option</td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">jGrowl options</th>
								</tr>
								<tr>
									<td>Sticky notice</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-sticky">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>When set to <code>true</code> a message will stick to the screen until it is intentionally closed by the user</td>
								</tr>
								<tr>
									<td>Long life</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-long-life">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>The lifespan of a non-sticky message on the screen. In current example it is 10 seconds</td>
								</tr>
								<tr>
									<td>Animation speed</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-animation">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>The animation speed used to open and close a notification. In current example it is <code>100ms</code></td>
								</tr>
								<tr>
									<td>Callbacks</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-callbacks">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>All callbacks receive the notification's DOM context, the notifications message and it's option object. Check out your <code>console</code></td>
								</tr>

								<tr class="table-border-double table-active">
									<th colspan="3">jGrowl positions</th>
								</tr>
								<tr>
									<td>Top left position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-top-left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top left notification position. To use, add <code>position: 'top-left'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Top center position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-top-center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top center notification position. To use, add <code>position: 'top-center'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Top right position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-top-right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Top right notification position. To use, add <code>position: 'top-right'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Page center position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Center notification position. To use, add <code>position: 'center'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Bottom left position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-bottom-left">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom left notification position. To use, add <code>position: 'bottom-left'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Bottom center position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-bottom-center">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom center notification position. To use, add <code>position: 'bottom-center'</code> option to the notification config</td>
								</tr>
								<tr>
									<td>Bottom right position</td>
									<td><button type="button" class="btn btn-light" id="jgrowl-bottom-right">Launch <i class="icon-play3 ml-2"></i></button></td>
									<td>Bottom right notification position. To use, add <code>position: 'bottom-right'</code> option to the notification config</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /jGrowl notifications -->

			</div>
			<!-- /content area -->


			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</span>

					<ul class="navbar-nav ml-lg-auto">
						<li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
						<li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
						<li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
					</ul>
				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->


@endsection
