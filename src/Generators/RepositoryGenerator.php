<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class RepositoryGenerator
 * @package Aruberuto\Workflow\Generators
 */
class RepositoryGenerator extends Generator
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
    protected $stub = 'repository/eloquent';

    /**
     * Get stub Interface name.
     *
     * @var string
     */
    protected $interfaceStub = 'repository/interface';

    /**
     * Get destination Interface path for generated file.
     *
     * @return string
     */
    public function getInterfacePath()
    {
        $return = $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. str_replace('\\', '/', $this->getParentNameOfClassRoute()) . $this->getClass() . 'Interface.php';
        // Log::debug($return);
        return $return;
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getInterfaceStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' . $this->interfaceStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' . $this->interfaceStub . '.stub', $this->getReplacements()))->render();
    }


    /**
     * Run the generator.
     *
     * @return int
     * @throws FileAlreadyExistsException
     */
    public function run()
    {
        parent::run();

        $path = $this->getInterfacePath();
        if($this->option('remove')) {
            $this->removeRun($path);
        } else {
            if ($this->filesystem->exists($path) && !$this->force) {
                throw new FileAlreadyExistsException($path);
            }
            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0777, true, true);
            }

            return $this->filesystem->put($path, $this->getInterfaceStub());

        }

    }

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'repository';
    }

}
