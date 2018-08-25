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
class ProviderGenerator extends Generator
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
    protected $stub = 'provider/provider';


    /**
     * Get stub name.
     *
     * @var string
     */
    protected $bootStub = 'provider/boot';


    /**
     * Get stub name.
     *
     * @var string
     */
    protected $registerStub = 'provider/register';

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'provider';
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        $rootNamespace = $this->getRootNamespace();
        if ($rootNamespace == config('workflow.rootNamespace', 'App') ){
            $return = 'WorkflowServiceProvider';
        } else {
            $return = str_replace('\\', '/', $this->getParentNameOfClassRoute())  . $this->getProviderName();
        }
        return $return;
    }

    public function getProviderName() {

        $return = $this->getPackageName() . 'ServiceProvider';
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

            $this->bootAndRegisterStub();
        }


    }

    public function bootAndRegisterStub() {

        \File::put($this->getPath(), str_replace('//:bootMethodProvider:', rtrim($this->getBootStub()) , \File::get($this->getPath())));
        \File::put($this->getPath(), str_replace('//:registerMethodProvider:', rtrim($this->getRegisterStub()) , \File::get($this->getPath())));

    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getBootStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' .  $this->bootStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->bootStub . '.stub', $this->getReplacements()))->render();
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getRegisterStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' . $this->registerStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->registerStub . '.stub', $this->getReplacements()))->render();
    }

}
