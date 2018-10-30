<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Log;

/**
 * Class SeederGenerator
 * @package Aruberuto\Workflow\Generators
 */
class SeederGenerator extends Generator
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
    protected $stub = 'seeder/seeder';

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'seeder';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {

        $base_path = $this->hasOption('path') ? base_path() .'/'. $this->normalizePath($this->path): base_path() ;
        $base_path =  $this->hasOption('src') && $this->src ? $base_path .'/src': $base_path;

        return $this->normalizePath($base_path);
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'fields' => $this->getFields()
        ]);
    }

    public function getFields() {
        return '// Here comes the new fields';
    }

    public function removeRun($path, $dirDelete = true) {
        parent::removeRun($path);
        // Two levels of delete directories
        $upDir = dirname(dirname($path));
        $this->deleteIfEmpty($upDir);


    }



}
