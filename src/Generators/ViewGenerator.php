<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class ViewGenerator
 * @package Aruberuto\Workflow\Generators
 */
class ViewGenerator extends Generator
{
    public function __construct(array $options = []) {
        parent::__construct($options);
        // $reflection = new \ReflectionClass(__CLASS__);
        // $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        // $filter = [];
        // foreach($methods as $method) {
        //     if(
        //         $method->getNumberOfParameters() != 0 ||
        //         in_array($method->name, ['run', '__construct', 'getStub'])

        //     ) {
        //         $result[$method->name] = "NOT_FIRED";

        //     } else {

        //         $filter[] = $method;
        //         $result[$method->name] = $method->invoke($this);
        //     }
        // }
        // dd($result);
    }

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = null;
    protected $viewsStub = [
        'index' =>'view/index',
        'create' =>'view/create',
        'edit' =>'view/edit',
        'show' =>'view/show',
    ];
    protected $currentView = null;
    protected $allowedViews = ['index', 'create', 'edit', 'show'];
    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {

        $base_path = $this->hasOption('path') ? base_path() .'/'. $this->normalizePath($this->path): base_path() ;

        return $this->normalizePath($base_path);
    }


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        $return =  $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. $this->getPluralName() .'/'. $this->currentView . '.blade.php';
        // Log::debug($return);
        return $return;

    }


    /**
     * Run the generator.
     *
     * @return int
     * @throws FileAlreadyExistsException
     */
    public function run()
    {
        foreach($this->option('views', []) as $view) {
            if(in_array($view, $this->allowedViews) && isset($this->viewsStub) && isset($this->viewsStub[$view])) {
                $this->currentView = $view;
                $this->stub = $this->viewsStub[$view];
                parent::run();
            } else {
                continue;
            }

        }

    }

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'view';
    }

    public function removeRun($path, $dirDelete = true) {
        parent::removeRun($path);
        // Two levels of delete directories
        $upDir = dirname(dirname($path));
        if ($this->filesystem->isDirectory($upDir)) {
            $otherFiles = $this->filesystem->allFiles($upDir);
            if(count($otherFiles) === 0) {
                $this->filesystem->deleteDirectory($upDir);
            }

        }

    }

}
