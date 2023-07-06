<?php

namespace App\Providers;

use App\Permission;
use Gate;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    
    /**
     * Register any authentication / authorization services.
     *
     * @param Gate $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::before(function ($admin) {
            if ($admin->isSuperAdmin()) {
                return true;
            }
        });
        
        if (Schema::hasTable('permissions')) {
            
            $permissions = $this->getPermissions();
    
            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($admin) use ($permission) {
                    return $admin->hasRole($permission->roles);
                });
            }
        }
        
        Passport::routes();
        
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(90));
    }
    
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
    
}
