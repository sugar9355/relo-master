
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

                            <a href="{{ route('admin.canned_mail') }}" class="btn btn-link btn-float text-default"><i class="icon icon-mailbox text-primary"></i><span>Canned Response</span></a>
                            <a href="{{ route('admin.shufflepeakfactor.index') }}" class="btn btn-link btn-float text-default"><i class="icon-graph text-primary"></i><span>Shuffle Peak Factor</span></a>
                            <a href="#" class="btn btn-link btn-float text-default" data-toggle="modal" data-target="#radius"><i class="icon icon-location3 text-primary"></i><span>Distance Locater</span></a>
                            <a href="{{ route('admin.accuracy.index') }}" class="btn btn-link btn-float text-default"><i         class="icon icon-chart text-primary"></i><span>Accuracy</span></a>
                            <a href="{{ route('admin.propertyInsurance.index') }}" class="btn btn-link btn-float text-default"><i class="icon icon-home5 text-primary"></i><span>Insurance</span></a>
                            <a href="{{ route('admin.timecharges.index') }}" class="btn btn-link btn-float text-default"><i class="icon-coin-dollar text-primary"></i><span>Time Charges</span></a>
                            <a href="{{ route('admin.peakfactor.index') }}" class="btn btn-link btn-float text-default"><i class="icon-graph text-primary"></i><span>Peak Factor</span></a>
                            <a href="{{ route('admin.godeye') }}" class="btn btn-link btn-float text-default"><i class="icon-file-eye text-primary"></i><span>God Eye</span></a>
                            
                            @can('smspanel')
                            <a href="{{ route('admin.chat') }}" class="btn btn-link btn-float text-default"><i class="icon-envelope text-primary"></i><span>@lang('admin.include.smsPanel')</span></a>
                            @endcan
                                                        
                            <div class="modal fade" id="radius" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Distance Locater</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.setRadius') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Job Search Radius</label>
                                                    <input type="text" class="form-control" name="distance_radius" id="distance_radius">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-link btn-float text-default"><div class="card" style="margin-bottom: 0px !important"><div class="card-bodys"><img class="w-20" src="{{url('assets_admin/images/logo/calendar.png')}}"> </div><span style="padding: 0px 5px 0px 5px;">Celender</span></div></a>
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
                        
                            @if(isset($hublocation))
                            <a href="{{ route('admin.hublocation.edit', $hublocation->id) }}" class="breadcrumb-elements-item" ><i class="icon-location4 mr-2 text-purple-600"></i>Hub</a>
                            @endif
                            
                            
                            
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
            
            <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-purple">
                    <h4 class="modal-title"><i class="icon-location4 mr-2 text-white"></i> Hub Location</h4>
                
              </div>
              <div class="modal-body">
                <strong><h5><i class="icon-location3 mr-2"></i>@if(isset($hub->address)){{$hub->address}}@endif</h5></strong>
              </div>
              <div class="modal-footer border border-top pt-2 pb-2">
              
                <button type="button" class="btn bg-purple" >Save</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>