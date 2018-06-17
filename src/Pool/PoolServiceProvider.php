<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Analytics;
use FosterMadeCo\Pool\Fields\IdentityTraits;
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

        $this->registerIdentityTraits();
    }

    /**
     * Register the IdentityTraits
     */
    public function registerAnalytics()
    {
        $this->app->singleton('analytics', function ($app) {
            return new Analytics();
        });
    }

    /**
     * Register the IdentityTraits
     */
    public function registerIdentityTraits()
    {
        $this->app->bind(IdentityTraits::class, function ($app) {
            return new IdentityTraits($app->make('validator'));
        });
    }
}