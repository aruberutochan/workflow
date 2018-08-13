<?php

namespace Aruberuto\Workflow;

use Illuminate\Support\ServiceProvider;

class WorkflowServiceProvider extends ServiceProvider
{
     /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/resources/config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(   __DIR__ . '/resources/config/repository.php' , 'repository');

        $this->loadTranslationsFrom(   __DIR__ . '/resources/lang' , 'workflow');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Aruberuto\Workflow\Generators\Commands\ServiceCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\AruControllerCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\AruEntityCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\AruRequestCommand');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
