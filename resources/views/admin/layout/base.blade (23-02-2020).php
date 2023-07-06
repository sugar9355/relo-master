<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>


	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>

	<script src="{{asset('assets_admin/js/app.js')}}"></script>
	<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
	<!-- /theme JS files -->

</head>

<body>



			
				<div class="row">
				
					<div class="col-md-4">
						

						<div class="card card-body border-top-primary">
							<div class="text-center">
								<h6 class="mb-1 font-weight-semibold">Slider methods</h6>
								<div class="mb-3 text-muted">
									<div class="form-check form-check-switchery form-check-switchery-double">
										<label class="form-check-label">
											Disable slider
											<input type="checkbox" class="switchery" checked data-fouc>
											Enable slider
										</label>
									</div>
								</div>
							</div>

							<div class="mb-1">
								<div class="ui-slider-horizontal jui-slider-methods" data-fouc></div>
							</div>
						</div>
					</div>
						<div class="col-md-4">
						<div class="card card-body border-top-primary">
							<div class="text-center">
								<h6 class="mb-0 font-weight-semibold">Display labels with pips</h6>
								<p class="mb-3 text-muted">Using <code>rest: 'label'</code> option</p>
							</div>

							<div class="ui-slider-horizontal ui-slider-pips jui-slider-labels" data-fouc></div>
						</div>

						
					</div>
					
				</div>
				<!-- /jQuery UI basic sliders -->


				

					
				<!-- /jQuery UI slider sizes -->


</body>
</html>
