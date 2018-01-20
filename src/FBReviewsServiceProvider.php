<?php

namespace DivArt\FBReviews;
use Illuminate\Support\ServiceProvider;

class FBReviewsServiceProvider extends ServiceProvider
{
    public function boot() {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->registerPublishables();
    }
    
    public function register() {
        $this->app->bind('fbreview', function () {
            return new FBReviews;
        });
    }

    public function registerPublishables() {
        $this->publishes([
            __DIR__ . "/config/fbreview.php" => config_path('fbreview.php'),
        ]);

        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/models' => app_path()
        ], 'models');

        $this->commands(["\DivArt\FBReviews\Commands\FbReviewsCommand"]);
    }
}