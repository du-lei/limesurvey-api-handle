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
        //
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
