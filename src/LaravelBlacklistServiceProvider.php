<?php

namespace LSurma\LaravelBlacklist;

use Illuminate\Support\ServiceProvider;
use LSurma\LaravelBlacklist\Commands\Seed;
use LSurma\LaravelBlacklist\Models\Blacklist;

class LaravelBlacklistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Seed::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations') 
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/blacklist.php' => config_path('blacklist.php') 
        ], 'config');
        
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'blacklist');
        
        $this->publishes([
            __DIR__ . '/../resources/lang/' => resource_path('lang/vendor/blacklist/') 
        ], 'lang');

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blacklist.php', 'blacklist');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getBlacklistModel()
    {
        $class = config('blacklist.model', Blacklist::class);

        return $class;
    }
}