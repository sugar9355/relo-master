    <?php

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */


    Route::group(['as' => 'admin.'], function () {
        

        
        Route::get('/get_storage_events_count', 'UserStorageRequestController@getEventsCount')->name('getStorageEventsCount');
        Route::get('/get_radius', 'AdminController@get_radius')->name('getRadius');
        Route::post('/set_radius', 'AdminController@set_radius')->name('setRadius');
        Route::get('/get_junk_events_count', 'UserJunkRequestController@getEventsCount')->name('getJunkEventsCount');
        Route::get('/', 'AdminController@dashboard')->name('index');
        Route::get('/get_events', 'AdminController@getAllEvents')->name('getAllEvents');
        Route::get('/booking_detail/{booking_id}/{date}/{type}', 'AdminController@booking_detail')->name('booking_detail');
        Route::get('/booking_items/{booking_id}/{date}/{type}', 'AdminController@booking_items')->name('booking_items');
        Route::post('/price_update/{booking_id}', 'AdminController@price_update')->name('price_update');

        Route::post('/items_quantity/{booking_id}', 'AdminController@items_quantity')->name('items_quantity');
        Route::get('delete_item/{booking_id}/{booking_item_id}', 'AdminController@delete_item')->name('delete_item');
        Route::post('add_item/{booking_id}/', 'AdminController@add_item')->name('add_item');

        Route::get('sms', 'AdminController@chat')->name('chat');
        Route::post('booking_status','AdminController@changeStatus')->name('booking_status');
        Route::get('mail','AdminController@Mailsend')->name('send_mail');
        Route::get('text-defination','AdminController@TextDefined')->name('text-defination');
        Route::post('text-defination-save','AdminController@TextDefinedsave')->name('text-defination-save');
        Route::get('canned_mail','AdminController@mail')->name('canned_mail');
        Route::get('canned_sms','AdminController@cannedsms')->name('canned_sms');
        Route::post('save-template','AdminController@saveMailTemplate')->name('save-template');
        Route::post('save-smstemplate','AdminController@saveSmsTemplate')->name('save-smstemplate');
        Route::get('edit-template/{id}','AdminController@editMailTemplate')->name('edit-template');
        Route::get('edit-smstemplate/{id}','AdminController@editSmsTemplate')->name('edit-smstemplate');
        Route::get('bulk_email','AdminController@bulkMail')->name('bulk_email');
        Route::post('sendbulk_email','AdminController@sendbulkMail')->name('sendbulk_email');
        
        Route::post('get-email','AdminController@getEmail')->name('get-email');
        Route::post('send_messages', 'AdminController@sendMessage')->name('send_messages');

    Route::post('user_search', 'AdminController@userSearch')->name('user_search');
    Route::get('create_inventory_type','AdminController@get_inventoryType')->name('create_inventory_type');

    Route::post('inventory_creation','AdminController@inventoryCreation')->name('inventory_creation');

        Route::get('/booking_locations/{booking_id}', 'AdminController@booking_locations')->name('booking_locations');
        Route::get('/godeye', 'GodEyeController@index')->name('godeye');
        Route::get('/godeye/status/{status}', 'GodEyeController@status')->name('godeye.status');
        Route::get('/update_date/{id}/{date}', 'AdminController@updateDate')->name('updateDate');
        Route::any('/dashboard/', 'AdminController@dashboard')->name('dashboard');
        Route::any('/shuffle_show/', 'AdminController@shuffle_show')->name('shuffle_show');
        Route::any('/working_hours/{id?}/{day?}/{time?}', 'AdminController@working_hours')->name('working_hours');
        Route::resource('hublocation', 'HubLocationController');
        Route::get('/heatmap', 'AdminController@heatmap')->name('heatmap');
        Route::get('/translation',  'AdminController@translation')->name('translation');
        Route::resource('system_user', 'SystemUserController');
        Route::resource('role', 'RoleController');
        Route::resource('storage_hub', 'StorageHubController');
        Route::group(['as' => 'role.', 'prefix' => 'role'], function (){
            Route::get('assign/{id}', 'RoleController@assign')->name('assign');
            Route::post('assign/{id}', 'RoleController@assignPermission')->name('assigned');
        });
        
        Route::resource('peakfactor', 'PeakFactorController');
        Route::resource('shufflepeakfactor', 'ShufflePeakFactorController');
        Route::resource('shuffle_fee', 'ShuffleFeeController');
        
        Route::get('demand_create', 'PeakFactorController@demand_create')->name('demand_create');
        Route::post('demand_store', 'PeakFactorController@demand_store')->name('demand_store');
        Route::get('reservation_fee', 'PeakFactorController@reservation_fee')->name('reservation_fee');
        Route::post('reservation_fee_store', 'PeakFactorController@reservation_fee_store')->name('reservation_fee_store');
        Route::resource('timecharges', 'TimeChargesController');
        
        Route::resource('opportunity', 'OpportunityController');
        Route::resource('designation', 'DesignationController');
        Route::resource('level', 'LevelController');
        Route::resource('dlevel', 'DlevelController');
        
        Route::any('AddCrew/{id}', 'DlevelController@AddCrew')->name('AddCrew');
        Route::any('edit_crews/{dlevel_id}/{c_c_id}', 'DlevelController@edit_crews')->name('edit_crews');
        Route::post('save_crew_updates', 'DlevelController@save_crew_updates')->name('save_crew_updates');
        
        Route::resource('referal', 'ReferalController');
        Route::resource('video', 'VideoController');
        Route::resource('worker', 'WorkerController');
        Route::group(['as' => 'worker.', 'prefix' => 'worker'], function () {
            Route::get('/status/{id}', 'WorkerController@status')->name('status');
        });
        
        Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
            Route::get('/', 'DispatcherController@index')->name('index');
            Route::post('/', 'DispatcherController@store')->name('store');
            Route::get('/trips', 'DispatcherController@trips')->name('trips');
            Route::get('/cancelled', 'DispatcherController@cancelled')->name('cancelled');
            Route::get('/cancel', 'DispatcherController@cancel')->name('cancel');
            Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
            Route::get('/users', 'DispatcherController@users')->name('users');
            Route::get('/providers', 'DispatcherController@providers')->name('providers');
        });
        
        Route::resource('user', 'Resource\UserResource');
        Route::resource('employee_rate', 'Resource\EmployeeRates');
        Route::resource('user_schedule', 'Resource\ScheduleResource');
        Route::resource('inventory', 'InventoryController');
        Route::resource('vehicle_schedule', 'VehicleScheduleController');
        Route::group(['as' => 'vehicle_schedule.', 'prefix' => 'vehicle_schedule'], function() {
            Route::get('calendar/{id}', 'VehicleScheduleController@vehicle_calendar')->name('calendar');
        });
        Route::resource('zone_type', 'ZoneTypeController');
        Route::resource('parking', 'ParkingController');
        Route::get('zoneExport', 'ZoneTypeController@zoneExport')->name('zoneExport');
        Route::post('zoneImport', 'ZoneTypeController@zoneImport')->name('zoneImport');
        Route::resource('vehicle', 'VehicleController');
        Route::group(['as' => 'vehicle.', 'prefix' => 'vehicle'], function () {
            Route::get('/{id}/service/', 'VehicleController@service')->name('service');
            Route::post('/{id}/service/', 'VehicleController@storeService')->name('serviceStore');
            /*Route::get('/{id}/fuel', 'VehicleController@fuel')->name('fuel');
            Route::post('/{id}/fuel/', 'VehicleController@storeFuel')->name('fuelStore');*/
            Route::get('/{id}/document', 'VehicleController@document')->name('document');
            Route::post('/{id}/document/', 'VehicleController@storeDocument')->name('documentStore');
            Route::get('/document/view', 'VehicleController@documentView')->name('documentView');
            Route::post('/document/search', 'VehicleController@searchDocument')->name('searchDocument');
            Route::get('/{id}/sticker', 'VehicleController@sticker')->name('sticker');
            Route::post('/{id}/sticker/', 'VehicleController@storeSticker')->name('stickerStore');
        });
        Route::group(['as' => 'logs.', 'prefix' => 'logs'], function () {
            Route::get('/', 'LogsController@index')->name('index');
            Route::post('/search', 'LogsController@search')->name('search');
        });
        Route::resource('vehicleType', 'VehicleTypeController');
        Route::resource('preset', 'PresetController');
        Route::resource('material', 'MaterialController');
        Route::resource('equipment', 'EquipmentController');
        Route::resource('dispatch-manager', 'Resource\DispatcherResource');
        Route::resource('account-manager', 'Resource\AccountResource');
        Route::resource('fleet', 'Resource\FleetResource');
        Route::resource('provider', 'Resource\ProviderResource');
        Route::get('assign_badges', 'CronJobController@AssignBadges')->name('AssignBadges');
        Route::get('update_user_level', 'CronJobController@UpgradeCaptainLevel')->name('UpgradeCaptainLevel');
        Route::resource('document', 'Resource\DocumentResource');
        Route::resource('services', 'ServiceController');
        Route::resource('service', 'Resource\ServiceResource');
        Route::resource('promocode', 'Resource\PromocodeResource');
        Route::resource('category', 'CategoryController');
        Route::resource('insurance', 'InsuranceCategoryController');
        Route::resource('propertyInsurance', 'PropertyInsuranceController');
        Route::resource('accuracy', 'AccuracyController');
        
        
        Route::group(['as' => 'provider.'], function () {
            Route::get('review/provider', 'AdminController@provider_review')->name('review');
            Route::get('provider/{id}/approve', 'Resource\ProviderResource@approve')->name('approve');
            Route::get('provider/{id}/disapprove', 'Resource\ProviderResource@disapprove')->name('disapprove');
            Route::get('provider/{id}/request', 'Resource\ProviderResource@request')->name('request');
            Route::get('provider/{id}/schedule', 'Resource\ProviderResource@schedule')->name('schedule');
            Route::get('provider/{id}/statement', 'Resource\ProviderResource@statement')->name('statement');
            Route::post('set_time/{id}/', 'Resource\ProviderResource@set_working_time')->name('set_time');
            Route::resource('provider/{provider}/document', 'Resource\ProviderDocumentResource');
            Route::resource('provider/{provider}/document/create', 'Resource\ProviderDocumentResource@create');
            Route::resource('provider/{provider}/document/do_create', 'Resource\ProviderDocumentResource@do_create');
            Route::delete('provider/{provider}/service/{document}', 'Resource\ProviderDocumentResource@service_destroy')->name('document.service');
        });
        
        Route::get('review/user', 'AdminController@user_review')->name('user.review');
        Route::get('user/{id}/request', 'Resource\UserResource@request')->name('user.request');
        
        Route::get('map', 'AdminController@map_index')->name('map.index');
        Route::get('map/ajax', 'AdminController@map_ajax')->name('map.ajax');
        
        Route::get('settings', 'AdminController@settings')->name('settings');
        Route::post('settings/store', 'AdminController@settings_store')->name('settings.store');
        Route::get('settings/payment', 'AdminController@settings_payment')->name('settings.payment');
        Route::get('settings/percentage', 'AdminController@settings_percentage')->name('settings.percentage');
        Route::post('settings/percentage', 'AdminController@settings_percentage_store')->name('settings.percentage.store');
        Route::post('settings/payment', 'AdminController@settings_payment_store')->name('settings.payment.store');
        
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profile_update')->name('profile.update');
        
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@password_update')->name('password.update');
        
        Route::get('payment', 'AdminController@payment')->name('payment');

    // statements
        
        Route::get('/statement', 'AdminController@statement')->name('ride.statement');
        Route::get('/statement/provider', 'AdminController@statement_provider')->name('ride.statement.provider');
        Route::get('/statement/today', 'AdminController@statement_today')->name('ride.statement.today');
        Route::get('/statement/monthly', 'AdminController@statement_monthly')->name('ride.statement.monthly');
        Route::get('/statement/yearly', 'AdminController@statement_yearly')->name('ride.statement.yearly');


    // Static Pages - Post updates to pages.update when adding new static pages.
        
        Route::get('/help', 'AdminController@help')->name('help');
        Route::get('/send/push', 'AdminController@push')->name('push');
        Route::post('/send/push', 'AdminController@send_push')->name('send.push');
        Route::get('/privacy', 'AdminController@privacy')->name('privacy');
        Route::post('/pages', 'AdminController@pages')->name('pages.update');
        Route::resource('requests', 'Resource\TripResource');
        
        Route::get('/user_request/get_events_count', 'UserRequestController@getEventsCount')->name('getEventsCount');
        Route::post('/user_request/send_message', 'UserRequestController@sendMessage');
        Route::post('/user_request/send_email', 'UserRequestController@sendEmail');
        Route::get('/user_request/get_item/{id}', 'UserRequestController@getItemById');
        Route::get('/user_request/{id}/edit_order', 'UserRequestController@editOrder')->name('user_request.editOrder');
        Route::patch('/user_request/{id}/update_order', 'UserRequestController@updateOrder')->name('user_request.updateOrder');
        Route::get('user_request/message_log', 'UserRequestController@messageLog')->name('request.message.log');
        Route::get('user_request/email_log', 'UserRequestController@emailLog')->name('request.email.log');
        
        Route::resource('user_request', 'UserRequestController');
        Route::resource('notification_schedule', 'NotificationScheduleController');
        Route::get('scheduled', 'Resource\TripResource@scheduled')->name('requests.scheduled');
        
        Route::get('push', 'AdminController@push_index')->name('push.index');
        Route::post('push', 'AdminController@push_store')->name('push.store');
        
        
        Route::get('/dispatch', function () {
            return view('admin.dispatch.index');
        });
        
        Route::get('/cancelled', function () {
            return view('admin.dispatch.cancelled');
        });
        
        Route::get('/ongoing', function () {
            return view('admin.dispatch.ongoing');
        });
        
        Route::get('/schedule', function () {
            return view('admin.dispatch.schedule');
        });
        
        Route::get('/add', function () {
            return view('admin.dispatch.add');
        });
        
        Route::get('/assign-provider', function () {
            return view('admin.dispatch.assign-provider');
        });
        
        Route::get('/dispute', function () {
            return view('admin.dispute.index');
        });
        
        Route::get('/dispute-create', function () {
            return view('admin.dispute.create');
        });
        
        Route::get('/dispute-edit', function () {
            return view('admin.dispute.edit');
        });
        
        Route::resource('user_storage_request', 'UserStorageRequestController');
        Route::group(['prefix' => 'user_storage_request', 'as' => 'user_storage_request.'], function () {
            
            Route::post('/send_message', 'UserStorageRequestController@sendMessage');
            Route::post('/send_email', 'UserStorageRequestController@sendEmail');
            Route::get('/get_item/{id}', 'UserStorageRequestController@getItemById');
            Route::get('/{id}/edit_order', 'UserStorageRequestController@editOrder')->name('editOrder');
            Route::patch('/{id}/update_order', 'UserStorageRequestController@updateOrder')->name('updateOrder');
        });
        
        Route::resource('user_junk_request', 'UserJunkRequestController');
        Route::group(['prefix' => 'user_junk_request', 'as' => 'user_junk_request.'], function () {
            Route::post('/send_message', 'UserJunkRequestController@sendMessage');
            Route::post('/send_email', 'UserJunkRequestController@sendEmail');
            Route::get('/get_item/{id}', 'UserJunkRequestController@getItemById');
            Route::get('/{id}/edit_order', 'UserJunkRequestController@editOrder')->name('editOrder');
            Route::patch('/{id}/update_order', 'UserJunkRequestController@updateOrder')->name('updateOrder');
        });
        Route::resource('rworker', 'RworkerController');
        Route::resource('flag', 'FlagController');
        Route::resource('supply', 'SupplyController');
        Route::get('format_category/{category_id}', 'InventoryController@format_category')->name('format_category');
        Route::get('select_category', 'InventoryController@index')->name('select_category');
        Route::get('category_duplicate/{category_id}', 'CategoryController@format_category')->name('category_duplicate');
        Route::post('/image_upload/{item_id}', 'InventoryController@image_upload')->name('image_upload');
        Route::resource('fixed_time', 'FixedTimeController');
        Route::group(['prefix' => 'fixed_time', 'as' => 'fixed_time.'], function() {
            // Route::
        });
        /*Route::get('add_permissions', function() {
            $permissionArray = [
                [
                    'name' => 'dashboard',
                    'label' => 'View Dashboard',
                ],
                [
                    'name' => 'godeye',
                    'label' => 'View God Eye',
                ],
                [
                    'name' => 'smspanel',
                    'label' => 'Control SMS Panel',
                ],
                [
                    'name' => 'system_users',
                    'label' => 'Manage System Users',
                ],
                [
                    'name' => 'roles',
                    'label' => 'Manage Roles',
                ],
                [
                    'name' => 'users',
                    'label' => 'Manage Users',
                ],
                [
                    'name' => 'captains',
                    'label' => 'Manage Captain',
                ],
                [
                    'name' => 'workers',
                    'label' => 'Manage Workers',
                ],
                [
                    'name' => 'designations',
                    'label' => 'Manage Designations',
                ],
                [
                    'name' => 'designation_videos',
                    'label' => 'Manage Designation Videos',
                ],
                [
                    'name' => 'item',
                    'label' => 'Manage Item',
                ],
                [
                    'name' => 'vehicle',
                    'label' => 'Manage Vehicle',
                ],
                [
                    'name' => 'zone_type',
                    'label' => 'Manage Zone Type',
                ],
                [
                    'name' => 'service_types',
                    'label' => 'Manage Service_types',
                ],
                [
                    'name' => 'presets',
                    'label' => 'Manage Pre Sets',
                ],
                [
                    'name' => 'notification_schedules',
                    'label' => 'Manage Notification Schedules',
                ],
                [
                    'name' => 'statements',
                    'label' => 'Manage Statements',
                ],
                [
                    'name' => 'item_categories',
                    'label' => 'Manage Item Categories',
                ],
                [
                    'name' => 'insurance_categories',
                    'label' => 'Manage Insurance Categories',
                ],
                [
                    'name' => 'rating',
                    'label' => 'View Ratings',
                ],
                [
                    'name' => 'moving_request',
                    'label' => 'Manage Moving Request',
                ],
                [
                    'name' => 'storage_request',
                    'label' => 'Manage Storage Request',
                ],
                [
                    'name' => 'junk_request',
                    'label' => 'Manage Junk Request',
                ],
                [
                    'name' => 'message_log',
                    'label' => 'View Message Log',
                ],
                [
                    'name' => 'email_log',
                    'label' => 'View Email Log',
                ],
                [
                    'name' => 'payment_history',
                    'label' => 'View Payment History',
                ],
                [
                    'name' => 'payment_settings',
                    'label' => 'Manage Payment Settings',
                ],
                [
                    'name' => 'percentage_settings',
                    'label' => 'Manage Percentage Settings',
                ],
                [
                    'name' => 'site_settings',
                    'label' => 'Manage Site Settings',
                ],
            ];
        
            foreach ($permissionArray as $permission) {
                $newPermission = new \App\Permission($permission);
                $newPermission->save();
            }
            
            echo "done";
            
        });*/
    });
