<?php
/*
|--------------------------------------------------------------------------
| Aruberuto Workflow Config
|--------------------------------------------------------------------------
|
|
*/
return [

    'basePath'      => app()->path(),
    'rootNamespace' => 'App\\',
    'stubsOverridePath' => app()->path(),
    'modelPath'       => 'Entities',
    'repositoryPath' => 'Repositories',
    'interfacePath'   => 'Repositories',
    'transformerPath' => 'Transformers',
    'presentersath'   => 'Presenters',
    'validatorPath'   => 'Validators',
    'controllerPath'  => 'Http/Controllers',
    'httpPath'         => 'Http',
    'providerPath'     => 'RepositoryServiceProvider',
    'criteriaPath'     => 'Criteria',
    'servicesPath'     => 'Services'


];
