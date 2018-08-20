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
            __DIR__ . '/resources/config/workflow.php' => config_path('workflow.php')
        ]);

        $this->mergeConfigFrom(   __DIR__ . '/resources/config/workflow.php' , 'workflow');

        $this->loadTranslationsFrom(   __DIR__ . '/resources/lang' , 'workflow');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateControllerCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateCriteriaCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateEntityCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateModelCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GeneratePresenterCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateRequestCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateServiceCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateTransformerCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateValidatorCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateWorkflowEntityCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateMigrationCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateRepositoryCommand');
        $this->commands('Aruberuto\Workflow\Generators\Commands\GenerateResourceCommand');




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
