<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('canany', function ($expression)
        {
            return "<?php if (app(\Illuminate\\Contracts\\Auth\\Access\\Gate::class)->any({$expression})): ?>";
        });
    
        Blade::directive('endcanany', function ()
        {
            return '<?php endif; ?>';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
