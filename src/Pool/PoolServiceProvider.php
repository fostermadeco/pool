<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Fields\PageProperties;
use Illuminate\Support\ServiceProvider;
use Segment;

class PoolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/segment.php' => config_path('segment.php')
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app['config']->has('segment.secret') && $this->app['config']->get('segment.secret') !== null) {
            Segment::init(
                $this->app['config']->get('segment.secret'),
                $this->app['config']->get('segment.options')
            );
        }

        $this->registerAnalytics();
    }

    /**
     * Register the Analytics Facade
     */
    public function registerAnalytics()
    {
        $this->app->singleton('analytics', function ($app) {
            return new Analytics();
        });
    }
}