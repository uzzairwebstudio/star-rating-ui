<?php

namespace UzzairWebStudio\StarRatingUI;

use Illuminate\Support\ServiceProvider;

class StarRatingUIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'star-rating-ui');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // initiate class
        $this->app->singleton(StarRatingUI::class, function () {
            return new StarRatingUI();
        });

        // helper files
        $files = [__DIR__ . 'helpers/Helper.php'];
        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once($file);
            }
        }

        // define alias
        $this->app->alias(StarRatingUI::class, 'star-rating-ui');

        // merge config file from vendor/uzzaircode/star-rating-ui/config/ folder
        $this->mergeConfigFrom(__DIR__ . '/config/star-rating-ui.php', 'star-rating-ui');

        // publish vendor assets

        # assets
        $this->publishes([
            __DIR__ . '/assets/css' => public_path('css/star-rating-ui'),
            __DIR__ . '/assets/js' => public_path('js/star-rating-ui'),
        ], 'assets');

        # views
        $this->publishes([
            __DIR__ . '/views' => resource_path('/views/vendor/star-rating-ui')
        ], 'views');

        # config files
        $this->publishes([
            __DIR__ . '/config/star-rating-ui.php' => config_path('star-rating-ui.php')
        ], 'config');
    }
}
