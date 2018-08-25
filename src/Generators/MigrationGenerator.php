<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Log;

/**
 * Class MigrationGenerator
 * @package Aruberuto\Workflow\Generators
 */
class MigrationGenerator extends Generator
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
    protected $stub = 'migration/create';

    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'migration';
    }

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
        $return =  $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. $this->getFileName() . '.php';
        // Log::debug($return);
        return $return;

    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {

        return Str::studly($this->getMigrationName());
    }


    /**
     * Get file name.
     *
     * @return string
     */
    public function getFileName()
    {
        return (new \DateTime())->format('Y_m_d_Hisu_') . $this->getMigrationName();
    }


    /**
     * Get migration name.
     *
     * @return string
     */
    public function getMigrationName()
    {
        return strtolower('create_' . str_plural($this->name) . '_table');
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

    public function removeRun($path, $dirDelete = false) {
        $migration_files = $this->filesystem->files(dirname($path));
        foreach($migration_files as $file) {
            if(strpos($file->getFilename(), $this->getMigrationName() ) !== false) {
                if($this->hasOption('path') && $this->option('path')) {
                    parent::removeRun($file->getPathname(), true);
                } else {
                    parent::removeRun($file->getPathname(), false);
                }
            }
        }
        // Two levels of delete directories
        if($this->hasOption('path') && $this->option('path')) {

            $upDir = dirname(dirname($path));
            if ($this->filesystem->isDirectory($upDir)) {
                $otherFiles = $this->filesystem->allFiles($upDir);
                if(count($otherFiles) === 0) {
                    $this->filesystem->deleteDirectory($upDir);
                }
            }
        }
    }



}
