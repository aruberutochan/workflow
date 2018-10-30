<?php
namespace Aruberuto\Workflow\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// use Illuminate\Support\Facades\Log;

abstract class Generator
{

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The array of options.
     *
     * @var array
     */
    protected $options;

    /**
     * The shortname of stub.
     *
     * @var string
     */
    protected $stub;


    /**
     * Create new instance of this class.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->filesystem = new Filesystem;
        $this->options = $options;


    }


    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }


    /**
     * Set the filesystem instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    public function getVendorName() {
        $rootNamespace = explode('\\', $this->getRootNamespace());
        $return = isset($rootNamespace[0]) ?   $rootNamespace[0] : 'App';
        return $return;
    }

    public function getPackageName() {
        $rootNamespace = explode('\\', $this->getRootNamespace());
        $return = end($rootNamespace) ? end($rootNamespace) : 'App';
        return $return;
    }


    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getStub()
    {
        $path = config('workflow.stubsOverridePath', __DIR__);

        if(!file_exists($path . '/Stubs/' . $this->stub . '.stub')){
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' . $this->stub . '.stub', $this->getReplacements()))->render();
    }


    /**
     * Get template replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return [
            'class'          => $this->getClass(),
            'name'           => $this->getName(),
            'namespace'      => $this->getNamespace(),
            'root_namespace' => $this->getRootNamespace(),
            'request'        => $this->getRequestName(),
            'controller'     => $this->getControllerName(),
            'service'        => $this->getServiceName(),
            'plural'         => $this->getPluralName(),
            'singular'       => $this->getSingularName(),
            'validator'      => $this->getValidatorName(),
            'repository'     => $this->getRepositoryName(),
            'appname'        => $this->getRootNamespace(),
            'vendorname'     => $this->getVendorName(),
            'packagename'    => $this->getPackageName(),
            'views_package'  => strtolower($this->getPackageName()),
        ];
    }


    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        $base_path = $this->hasOption('path') && $this->path ? base_path() .'/'. $this->normalizePath($this->path): base_path()  .'/'. config('workflow.appPath', 'app');
        // Log::debug($base_path);
        $base_path =  $this->hasOption('path') && $this->path && $this->hasOption('src') && $this->src ? $base_path .'/src': $base_path;
        return $this->normalizePath($base_path);
    }

    public function normalizePath($path) {
        return rtrim($path, '/');
    }


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {

        $return = $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. str_replace('\\', '/', $this->getParentNameOfClassRoute()) . $this->getClass() . '.php';
        // Log::debug($return);
        return $return;
    }

    /**
     * Get name input.
     *
     * @return string
     */
    public function getName()
    {
        $name = $this->name;
        if (str_contains($this->name, '\\')) {
            $name = str_replace('\\', '/', $this->name);
        }
        if (str_contains($this->name, '/')) {
            $name = str_replace('/', '/', $this->name);
        }
        // dd($name);
        return ucwords(basename($name));
    }

    /**
     * Get name input.
     *
     * @return string
     */
    public function getClassRoute()
    {
        $name = $this->name;
        if (str_contains($this->name, '/')) {
            $name = str_replace('/', '\\', $this->name);
        }

        $return = str_replace(' ', '\\', ucwords(str_replace('\\', ' ', $name)));
        return  str_replace(' ', '\\', ucwords(str_replace('\\', ' ', $name)));

    }

    public function getParentNameOfClassRoute() {
        $str = $this->getClassRoute();
        return substr($str, 0,strrpos($str, '\\'));
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {
        return str_plural(lcfirst(ucwords($this->getName())));
    }




    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return str_singular(lcfirst(ucwords($this->getName())));
    }


    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        $class = $this->getName() . ucfirst($this->getClassType());
        return Str::studly(class_basename($class));
    }

    abstract public function getClassType();


    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return $this->hasOption('root-namespace') && $this->option('root-namespace') ? $this->option('root-namespace') : config('workflow.rootNamespace', $this->getAppNamespace());
    }

    public function getNameByClassType($class) {
        return ucwords($this->getName()) . ucfirst($class);
    }

    /**
     * Get class-specific output paths.
     *
     * @param $class
     *
     * @return string
     */
    public function getConfigGeneratorClassPath($class, $directoryPath = false)
    {
        switch ($class) {
            case ('model' === $class):
                $path = config('workflow.modelPath', 'Entities');
                break;
            case ('repository' === $class):
                $path = config('workflow.repositoryPath', 'Repositories');
                break;
            case ('interface' === $class):
                $path = config('workflow.interfacePath', 'Repositories');
                break;
            case ('presenter' === $class):
                $path = config('workflow.presenterPath', 'Presenters');
                break;
            case ('transformer' === $class):
                $path = config('workflow.transformerPath', 'Transformers');
                break;
            case ('validator' === $class):
                $path = config('workflow.validatorPath', 'Validators');
                break;
            case ('controller' === $class):
                $path = config('workflow.controllerPath', 'Http\Controllers');
                break;
            case ('resource' === $class):
                $path = config('workflow.resourcePath', 'Http\Resources');
                break;
            case ('request' === $class):
                $path = config('workflow.requestPath', 'Http\Requests');
                break;
            case ('migration' === $class):
                $path = config('workflow.migrationPath', 'database\migrations');
                break;
            case ('seeder' === $class):
                $path = config('workflow.seederPath', 'database\seeds');
                break;
            case ('factory' === $class):
                $path = config('workflow.factoryPath', 'database\factories');
                break;
            case ('service' === $class):
                $path = config('workflow.servicePath', 'Services');
                break;
            case ('provider' === $class):
                $path = config('workflow.providerPath', 'Providers');
                break;
            case ('criteria' === $class):
                $path = config('workflow.criteriaPath', 'Criteria');
                break;
            case ('helper' === $class):
                $path = config('workflow.helperPath', 'Helpers');
                break;
            case ('route' === $class):
                $path = config('workflow.helperPath', 'routes');
                break;
            case ('view' === $class):
                $path = config('workflow.viewPath', 'resources\views');
                break;
            default:
                $path = '';
        }

        if ($directoryPath) {
            $path = str_replace('\\', '/', $path);
        } else {
            $path = str_replace('/', '\\', $path);
        }


        return $path;
    }

    /**
     * Get class namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        $rootNamespace = $this->getRootNamespace();
        if ($rootNamespace == false) {
            return null;
        }
        return rtrim($rootNamespace . '\\' . $this->getConfigGeneratorClassPath($this->getClassType(), false) . '\\'. $this->getParentNameOfClassRoute() , '\\');
    }

    /**
     * Get application namespace
     *
     * @return string
     */
    public function getAppNamespace()
    {
        // Return 'App\'
        return \Illuminate\Container\Container::getInstance()->getNamespace();
    }

    /**
     * Setup some hook.
     *
     * @return void
     */
    public function setUp()
    {
        //
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
            if ($this->filesystem->exists($path) && !$this->force) {
                throw new FileAlreadyExistsException($path);
            }
            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0777, true, true);
            }

            return $this->filesystem->put($path, $this->getStub());
        }

    }

    public function removeRun($path, $dirDelete = true) {

        if ($this->filesystem->exists($path)) {

            $this->filesystem->delete($path);
            if($dirDelete) {
                $this->deleteIfEmpty(dirname($path));
            }


        } else {
            throw new FileNotFoundException($path);
        }
    }

    public function deleteIfEmpty($dir) {
        if ($this->filesystem->isDirectory($dir)) {
            $otherFiles = $this->filesystem->allFiles($dir);
            if(count($otherFiles) === 0) {
                $this->filesystem->deleteDirectory($dir);
            }

        }
    }


    /**
     * Get options.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Determinte whether the given key exist in options array.
     *
     * @param  string $key
     *
     * @return boolean
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }


    /**
     * Get value from options by given key.
     *
     * @param  string      $key
     * @param  string|null $default
     *
     * @return string
     */
    public function getOption($key, $default = null)
    {
        if (!$this->hasOption($key)) {
            return $default;
        }

        return $this->options[$key] ?: $default;
    }


    /**
     * Helper method for "getOption".
     *
     * @param  string      $key
     * @param  string|null $default
     *
     * @return string
     */
    public function option($key, $default = null)
    {
        return $this->getOption($key, $default);
    }


    /**
     * Handle call to __get method.
     *
     * @param  string $key
     *
     * @return string|mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->option($key);
    }

    public function __call($key, $args) {
        if(method_exists($this, $key)) {
            return call_user_func_array([$this, $key], $args);
        }
        if(substr($key, -4) === 'Name' && substr($key, 0, 3) === 'get') {
            return $this->getNameByClassType(substr($key, 3, -4));
        }
    }
}
