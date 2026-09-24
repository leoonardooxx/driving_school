<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            foreach ($openApi->components->schemas as $name => $schema) {
                $schema->type->setExtensionProperty('tags', [str_ends_with($name, 'Request') ? 'Requests' : 'Models']);
            }
        });
    }
}
