<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->


            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- User menu -->
             <div class="sidebar-user">
                    <div class="card-body">
                        <div class="media">
                            <div class="mr-3">
                            <button type="button" class="btn btn-outline border-white text-white btn-icon rounded-round border-1 ml-2"><i class="icon-crown icon-2x"></i></button>
                                
                            </div>

                            <div class="media-body">
                                <div class="media-title font-weight-semibold">{{ucwords(Auth::guard('admin')->user()->name)}}</div>
                                
                                <div class="font-size-xs opacity-50">
                                    <i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA
                                </div>
                            </div>

                            <div class="ml-3 align-self-center">
                                <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /user menu -->
                
                


                <!-- Main navigation -->
                <div class="card card-sidebar-mobile">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">

                        <!-- Main -->

                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Dashboard</div> 
                            <i class="icon-menu" title="Main"></i>
                        </li>                        
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link">
                                <i class="icon-home4"></i>
                                <span>
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.working_hours') }}" class="nav-link">
                                <i class="icon-home4"></i>
                                <span>Working Hours</span>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-bubble-lines3"></i><span>Job Opportunity</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.opportunity.index') }}" class="nav-link"><i class="icon-list2"></i> List Opportunity</a></li>
                                <li class="nav-item"><a href="{{ route('admin.opportunity.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add Opportunity</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-map"></i><span>Zone Types</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.zone_type.index') }}" class="nav-link"><i class="icon-list2"></i> List Zones</a></li>
                                <li class="nav-item"><a href="{{ route('admin.zone_type.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add Zone</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-flag8"></i><span>Flag</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.flag.index') }}" class="nav-link"><i class="icon-list2"></i> List Flags</a></li>
                                <li class="nav-item"><a href="{{ route('admin.flag.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Flag</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.shuffle_fee.index') }}" class="nav-link">
                                <i class="icon-coin-dollar"></i>
                                <span>Shuffle Fees</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.fixed_time.index') }}" class="nav-link">
                                <i class="icon-database-time2"></i>
                                <span>Fixed Times</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.text-defination') }}" class="nav-link">
                                <i class="icon-database-time2"></i>
                                <span>Text Define</span>
                            </a>
                        </li>


                        
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Members & Workers</div> 
                            <i class="icon-menu" title="Main"></i>
                        </li>



                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-calendar3"></i> <span>User Schedule</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.user_schedule.index') }}" class="nav-link"><i class="icon-list2"></i> List User Schedule</a></li>
                                <li class="nav-item"><a href="{{ route('admin.user_schedule.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add User Schedule</a></li>
                            </ul>
                        </li>
                    
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-users4"></i> <span>Backend Users</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.system_user.index') }}" class="nav-link"><i class="icon-list2"></i> @lang('admin.include.list_users')</a></li>
                                <li class="nav-item"><a href="{{ route('admin.system_user.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> @lang('admin.include.add_new_user')</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-users2"></i> <span>Ground Operators</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.provider.index') }}" class="nav-link"><i class="icon-list2"></i> List Ground Operators</a></li>
                                <li class="nav-item"><a href="{{ route('admin.provider.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Operators</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-vcard"></i> <span>Workers</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.worker.index') }}" class="nav-link"><i class="icon-list2"></i> List Workers</a></li>
                                <li class="nav-item"><a href="{{ route('admin.worker.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Worker</a></li>
                            </ul>
                        </li>
                    
                    
                    
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-atom2"></i> <span>Badges</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.designation.index') }}" class="nav-link"><i class="icon-list2"></i> List Badges</a></li>
                                <li class="nav-item"><a href="{{ route('admin.designation.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Badges</a></li>
                            </ul>
                        </li>
                    
                    
                    
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Levels</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.level.index') }}" class="nav-link"><i class="icon-list2"></i> List Levels</a></li>
                                <li class="nav-item"><a href="{{ route('admin.level.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Level</a></li>
                            </ul>
                        </li>
                        
                         <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Difficulty Levels</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.dlevel.index') }}" class="nav-link"><i class="icon-list2"></i> List Levels</a></li>
                                <li class="nav-item"><a href="{{ route('admin.dlevel.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Level</a></li>
                            </ul>
                        </li>
                    
                    
                    
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-magazine"></i> <span>Referrals</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.referal.index') }}" class="nav-link"><i class="icon-list2"></i> List Referrals</a></li>
                                <li class="nav-item"><a href="{{ route('admin.referal.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Referral</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-file-media"></i> <span>Designation</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.role.index') }}" class="nav-link"><i class="icon-list2"></i> List Designation</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-film4"></i> <span>Designation Videos</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.video.index') }}" class="nav-link"><i class="icon-list2"></i> List Videos</a></li>
                                <li class="nav-item"><a href="{{ route('admin.video.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Video</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-stack3"></i> <span>Recommened Workers</span></a>
                            <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a href="{{ route('admin.rworker.index') }}" class="nav-link"><i class="icon-list2"></i> List Recommened Workers</a></li>
                                <li class="nav-item"><a href="{{ route('admin.rworker.create') }}" class="nav-link"><i class="icon-plus-circle2"></i> Add New Level</a></li>
                            </ul>
                        </li>
                       

    
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Inventory</div> 
                            <i class="icon-menu" title="Main"></i>
                        </li>

                        
                         <li class="nav-item nav-item-submenu">
                            
                                <li class="nav-item nav-item-submenu">
                                        <a href="#" class="nav-link"><i class="icon-box"></i> <span>Inventory</span></a>
                                        <ul class="nav nav-group-sub" style="display: none;">
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.inventory.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_items')</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.inventory.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_new_items')</a></li>
                                </ul>
                                </li>
                                
                                
                                <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link"><i class="icon-dropbox"></i> <span>Item Category</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.category.index') }}"><i class="icon-list2"></i> List Category</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.category.create') }}"><i class="icon-plus-circle2"></i> Add Category</a></li>
                                    </ul>
                                </li>
                                
                                <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link"><i class="icon-dropbox"></i> <span>Insurance Category</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.insurance.index') }}"><i class="icon-list2"></i> List Insurance</a></li>
                                    </ul>
                                </li>
                                
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link"><i class="icon-dropbox"></i> <span>Packing Supplies</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                    
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.supply.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_supplies')</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.supply.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_new_supply')</a></li>
                                    
                                    </ul>
                                </li>

                                <li class="nav-item nav-item-submenu">
                                        <a href="#" class="nav-link"><i class="icon-cart5"></i> <span>Preset</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                    
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.preset.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_pre-set')</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.preset.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_new_pre-set')</a></li>
                                    
                                    </ul>
                                </li>
                                
                                <li class="nav-item nav-item-submenu">
                                        <a href="#" class="nav-link"><i class="icon-shear"></i> <span>Meterial</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                    
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.material.index') }}"><i class="icon-list2"></i> List Meterial</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.material.create') }}"><i class="icon-plus-circle2"></i> Add New Meterial</a></li>
                                    
                                    </ul>
                                </li>
                                
                                <li class="nav-item nav-item-submenu">
                                        <a href="#" class="nav-link"><i class="icon-angle"></i> <span>Equipment</span></a>
                                    <ul class="nav nav-group-sub" style="display: none;">
                                    
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.equipment.index') }}"><i class="icon-list2"></i> List Equipment</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.equipment.create') }}"><i class="icon-plus-circle2"></i> Add New Equipment</a></li>
                                        <li class="nav-item">
                            <a href="{{ route('admin.create_inventory_type') }}" class="nav-link">
                                <i class="icon-box"></i>
                                <span>Inventory Creation</span>
                            </a>
                        </li>
                                    </ul>
                                </li>
                                 <li class="nav-item">
                            <a href="{{ route('admin.create_inventory_type') }}" class="nav-link">
                                <i class="icon-box"></i>
                                <span>Inventory Creation</span>
                            </a>
                        </li>
                                
                            
                        </li>
                        
                        
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Vehicles</div> 
                            <i class="icon-menu" title="Main"></i>
                        </li>

                        
                         <li class="nav-item nav-item-submenu">

                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link"><i class="icon-truck"></i> <span>Vehicle</span></a>
                                <ul class="nav nav-group-sub" style="display: none;">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicle.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_vehicle')</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicle.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_vehicle')</a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link"><i class="icon-magazine"></i> <span>Vehicle Type</span></a>
                                <ul class="nav nav-group-sub" style="display: none;">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicleType.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_vehicle_type')</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicleType.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_vehicle_type')</a></li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link"><i class="icon-calendar"></i> <span>Vehicle Schedule</span></a>
                                <ul class="nav nav-group-sub" style="display: none;">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicle_schedule.index') }}"><i class="icon-list2"></i> @lang('admin.include.list_vehicle_schedule')</a></li>
                                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicle_schedule.create') }}"><i class="icon-plus-circle2"></i> @lang('admin.include.add_vehicle_schedule')</a></li> --}}
                                </ul>
                            </li>

                        </li>
                        
                        
                        
                          
                        
                        

                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->
            
        </div>