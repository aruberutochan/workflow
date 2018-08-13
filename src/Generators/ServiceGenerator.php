<?php
namespace Aruberuto\Workflow\Generators;
use Prettus\Repository\Generators\Generator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class ControllerGenerator
 * @package Aruberuto\Workflow\Generators
 */
class ServiceGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'service/service';

    /**
     * Get root namespace.
     *
     * @return string
     */

    public function getRootNamespace()
    {
        return str_replace('/', '\\', parent::getRootNamespace() . self::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'services';
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getStub()
    {
        $path = config('repository.generator.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' . $this->stub . '.stub')){
            $path = __DIR__;
        }
        return (new Stub($path . '/Stubs/' . $this->stub . '.stub', $this->getReplacements()))->render();
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        $path = $this->getBasePath() . '/' . self::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getServiceName() . 'Service.php';

        return $path;
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('repository.generator.basePath', app()->path());
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getServiceName()
    {

        return ucfirst(lcfirst(ucwords($this->getClass())));
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

        return 'use ' . str_replace([
            "\\",
            '/'
        ], '\\', $validator) . 'Validator;';
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
        if($class == 'services') {
            $path = config('repository.generator.paths.services', 'Services');
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
