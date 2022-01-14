<?php

namespace Mpie\LighthouseOAuth;

use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Events\BuildSchemaString;

class LighthouseOAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->registerConfig();

        app('events')->listen(
            BuildSchemaString::class,
            function (): string {
                if (config('lighthouse-oauth2.schema')) {
                    return file_get_contents(config('lighthouse-oauth2.schema'));
                }

                return file_get_contents(__DIR__.'/../../graphql/oauth2.graphql');
            }
        );
    }

    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('lighthouse-oauth2.php'),
        ], 'lighthouse-oauth2-config');

        $this->publishes([
            __DIR__.'/../graphql/oauth2.graphql' => base_path('graphql/oauth2.graphql'),
        ], 'lighthouse-oauth2-schema');
    }
}
