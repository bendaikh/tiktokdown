<?php

namespace App\Providers;

use App\Service\StorableConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton("config.storable", function($app) {
            return new StorableConfig($app);
        });

        $this->callAfterResolving('config', function($config, $app) {
            $app->make("config.storable")->merge($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
        public function boot(): void
    {
        // Schema::defaultStringLength(191);

        // Fake CodeSpikeX license API in local environment for development
        if ($this->app->environment('local')) {
            \Illuminate\Support\Facades\Http::fake([
                'api.codespikex.com/api/v2/license/*' => \Illuminate\Support\Facades\Http::response([
                    'status'     => 'active',
                    'usage'      => 0,
                    'max_usage'  => 1000,
                    'resets_at'  => now()->addMonth()->toDateString(),
                ], 200),
            ]);
        }
    }
}
