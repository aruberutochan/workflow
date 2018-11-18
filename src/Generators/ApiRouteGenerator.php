<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class ProviderGenerator
 * @package Aruberuto\Workflow\Generators
 */
class ApiRouteGenerator extends Generator
{
    public function __construct(array $options = []) {
        parent::__construct($options);
        // $reflection = new \ReflectionClass(__CLASS__);
        // $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        // $filter = [];
        // foreach($methods as $method) {
        //     if(
        //         $method->getNumberOfParameters() != 0 ||
        //         in_array($method->name, ['run', '__construct', 'getStub', 'bootAndRegisterStub', 'getBootStub', 'getregisterStub'])

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
    protected $stub = 'route/api';


    /**
     * Get stub name.
     *
     * @var string
     */
    protected $routeStub = 'route/apiroute';

        /**
     * Get stub name.
     *
     * @var string
     */
    protected $useStub = 'route/use';

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'route';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {

        $return = $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. 'api.php';
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
        $this->setUp();
        $path = $this->getPath();

        if($this->option('remove')) {
            $this->removeRun($path);
        } else {
            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0777, true, true);
            }
            if (!$this->filesystem->exists($path)) {
                $this->filesystem->put($path, $this->getStub());
            }

            $this->routesStub();
        }


    }

    public function routesStub() {

        \File::put($this->getPath(), str_replace('//:NewRoutesAgregator:', rtrim($this->getRouteStub()) , \File::get($this->getPath())));
        \File::put($this->getPath(), str_replace('//:NewHelperFile:', rtrim($this->getUseStub()) , \File::get($this->getPath())));

    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getRouteStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' .  $this->routeStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->routeStub . '.stub', $this->getReplacements()))->render();
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getUseStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' .  $this->useStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->useStub . '.stub', $this->getReplacements()))->render();
    }

}
