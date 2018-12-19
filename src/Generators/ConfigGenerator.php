<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;
use Aruberuto\Configurable\Helpers\EloquentStructureHelper;
/**
 * Class ControllerGenerator
 * @package Aruberuto\Workflow\Generators
 */
class ConfigGenerator extends Generator
{
    public function __construct(array $options = []) {
        parent::__construct($options);
        // dd($options);
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

    protected $primarySetted = false;

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'config/config';

    protected $formFieldStub = 'config/form-fields';
    protected $displayFieldStub = 'config/display-fields';


    /**
     * Get Class type.
     *
     * @return string
     */
    public function getClassType()
    {
        return 'config';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {

        $return = $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. $this->name .'.php';
        // Log::debug($return);
        return $return;
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {

        $base_path = $this->hasOption('path') ? base_path() .'/'. $this->normalizePath($this->path): base_path() ;
        $base_path =  $this->hasOption('path') && $this->path && $this->hasOption('src') && $this->src ? $base_path .'/src': $base_path;

        return $this->normalizePath($base_path);
    }

    public function removeRun($path, $dirDelete = true) {
        parent::removeRun($path);
        // Two levels of delete directories
        $upDir = dirname(dirname($path));
        $this->deleteIfEmpty($upDir);

    }

    public function getNamespace() {
        return str_replace('\\' . class_basename($this->entity), '',  $this->entity );
    }

    public function run() {
        parent::run();
        $this->addFields();
    }

    public function addFields() {
        $structure = EloquentStructureHelper::getStructure($this->entity);
        $this->primarySetted = false;
        foreach($structure['fillableFields'] as $fillable) {
            \File::put($this->getPath(), str_replace('//:::form-fields:::', rtrim($this->getFormFieldStub($fillable)) , \File::get($this->getPath())));
        }
        $this->primarySetted = false;
        foreach($structure['dbColumns'] as $column) {
            \File::put($this->getPath(), str_replace('//:::display-fields:::', rtrim($this->getDisplayFieldStub($column)) , \File::get($this->getPath())));

        }
    }

    public function getFormFieldStub($field) {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' .  $this->formFieldStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->formFieldStub . '.stub', $this->getFieldReplacements($field)))->render();

    }

    public function getDisplayFieldStub($field) {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' .  $this->displayFieldStub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' .  $this->displayFieldStub . '.stub', $this->getFieldReplacements($field)))->render();

    }

    public function getReplacements() {
        $parent = parent::getReplacements();
        return array_merge($parent, [
            'entity_class' => $this->hasOption('entity') ? $this->entity : '',
        ]);
    }

    public function getFieldReplacements($field) {

        return [
            'field_name' => $field,
            'field_label' =>  EloquentStructureHelper::getLabelStr($field),
            'field_instructions' =>  EloquentStructureHelper::getInstructionStr($field, $this->entity),
            'field_level' =>  $this->getFieldLevel($field),
            'field_wrapper' => $this->getFieldLevel($field) === 0 ? 'h2' : '',
            'show_label' =>  $this->getFieldLevel($field) === 0 ? 'false' : 'true',
        ];
    }

    public function getFieldLevel($field) {
        if($field === 'id') {
            $level = '-1';
        } elseif(!$this->primarySetted && $field !== 'created_at' && $field !== 'updated_at') {
            $level = '0';
            $this->primarySetted = true;
        } else {
            $level = '1';
        }
        return $level;
    }


}
