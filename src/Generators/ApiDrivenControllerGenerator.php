<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class ControllerGenerator
 * @package Aruberuto\Workflow\Generators
 */
class ApiDrivenControllerGenerator extends Generator
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
    protected $stub = 'controller/apidriven';

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'controller';
    }

    public function removeRun($path, $dirDelete = true) {
        parent::removeRun($path);
        // Two levels of delete directories
        $upDir = dirname(dirname($path));
        $this->deleteIfEmpty($upDir);

    }

}
