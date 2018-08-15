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
class ControllerGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/controller';

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'controller';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . self::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getControllerName() . 'Controller.php';
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName()
    {
        return ucwords($this->getClass());
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getServiceName()
    {
        return ucwords($this->getClass()) . 'Service';
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {
        return str_plural(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {

        return array_merge(parent::getReplacements(), [
            'controller' => $this->getControllerName(),
            'service'    => $this->getServiceName(),
            'plural'     => $this->getPluralName(),
            'singular'   => $this->getSingularName(),
            'validator'  => $this->getValidator(),
            'repository' => $this->getRepository(),
            'appname'    => parent::getRootNamespace(),
        ]);
    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return str_singular(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Gets validator full class name
     *
     * @return string
     */
    public function getValidator()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name' => $this->name,
        ]);

        $validator = $validatorGenerator->getRootNamespace() . '\\' . $validatorGenerator->getName();

        return 'use ' . str_replace(["\\", '/'], '\\', $validator) . 'Validator;';
    }


    /**
     * Gets repository full class name
     *
     * @return string
     */
    public function getRepository()
    {
        $repositoryGenerator = new RepositoryInterfaceGenerator([
            'name' => $this->name,
        ]);

        $repository = $repositoryGenerator->getRootNamespace() . '\\' . $repositoryGenerator->getName();

        return 'use ' . str_replace([
            "\\",
            '/'
        ], '\\', $repository) . 'Repository;';
    }

    /**
     * Override parent Get class-specific output paths.
     *
     * @param $class
     *
     * @return string
     */
    public function getConfigGeneratorClassPath($class, $directoryPath = false)
    {
        if($class == 'controllers') {
            $path = config('workflow.controllerPath', 'Controller');
            if ($directoryPath) {
                $path = str_replace('\\', '/', $path);
            } else {
                $path = str_replace('/', '\\', $path);
            }
            return $path;
        } else {
            return parent::getConfigGeneratorClassPath($class, $directoryPath = false);
        }
    }


}
