
        <!-- Main content -->
        <div class="content-wrapper">
<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
					
					
					
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - {{ ucwords(str_replace("_"," ",Request::segment(2))) }}</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<a href="{{ route('admin.propertyInsurance.index') }}" class="btn btn-link btn-float text-default"><i class="icon icon-home5 text-primary"></i><span>Insurance</span></a>
							<a href="{{ route('admin.timecharges.index') }}" class="btn btn-link btn-float text-default"><i class="icon-coin-dollar text-primary"></i><span>Time Charges</span></a>
							<a href="{{ route('admin.peakfactor.index') }}" class="btn btn-link btn-float text-default"><i class="icon-graph text-primary"></i><span>Peak Factor</span></a>
							<a href="{{ route('admin.godeye') }}" class="btn btn-link btn-float text-default"><i class="icon-file-eye text-primary"></i><span>God Eye</span></a>
							
							 @can('smspanel')
									<form action="http://smssender.distance123.com/login_via_api" method="post" target="_blank">
										<input type="hidden" name="auth-key" value="97505c012268036c3e734501a8169e03">
										<button type="submit" class="btn btn-link btn-float text-default" id="sms-panel"><i class="icon-bubbles9 text-primary"></i> <span>@lang('admin.include.smsPanel')</span></button>
									</form>
							@endcan
							
							
							<a href="{{ route('admin.dashboard') }}" class="btn btn-link btn-float text-default"><i class="icon-calendar text-primary"></i> <span>Celender</span></a>
						</div>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">{{ ucwords(str_replace("_"," ",Request::segment(2))) }}</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
						
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">
							
							<div class="breadcrumb-elements-item dropdown p-0">
								<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
									<i class="icon-coins mr-2 text-warning-600"></i>
									@lang('admin.include.payment_details')
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ route('admin.payment') }}" class="dropdown-item"><i class="icon-history text-info"></i> @lang('admin.include.payment_history')</a>
									<a href="{{ route('admin.settings.payment') }}" class="dropdown-item"><i class="icon-gear text-purple"></i> @lang('admin.include.payment_settings')</a>
									<div class="dropdown-divider"></div>
									<a href="{{ route('admin.settings.percentage') }}" class="dropdown-item"><i class="icon-percent text-indigo"></i> @lang('admin.include.percentage_settings')</a>
								</div>
							</div>

							<div class="breadcrumb-elements-item dropdown p-0">
								<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear mr-2"></i>
									Settings
								</a>

								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ route('admin.profile') }}" class="dropdown-item"><i class="icon-user-lock"></i> Account Settings</a>
									<a href="{{ route('admin.password') }}" class="dropdown-item"><i class="icon-lock5"></i> Accessibility</a>
									<div class="dropdown-divider"></div>
									<a href="{{ route('admin.settings') }}" class="dropdown-item"><i class="icon-gear"></i> Site Settings</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>