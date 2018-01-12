<?php

namespace LaravelLimesurveyApi\Handle;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelLimesurveyApiProvider
 *
 * @package LaravelLimesurveyApi\Handle
 */
class LaravelLimesurveyApiProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot ()
    {
        $this->publishes( [
            __DIR__ . '/config/limesurveyApiHandle.php' => config_path( 'limesurveyApiHandle.php' ),
        ] );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register ()
    {
        $this->app->singleton( 'limesurveyApiHandle', function () {
            return new LimesurveyApiHandle();
        } );
    }
}
