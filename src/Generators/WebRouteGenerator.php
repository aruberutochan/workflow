<?php
namespace Aruberuto\Workflow\Generators;
use Aruberuto\Workflow\Generators\ApiRouteGenerator;
use Prettus\Repository\Generators\Stub;
use Prettus\Repository\Generators\ValidatorGenerator;
use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

/**
 * Class ProviderGenerator
 * @package Aruberuto\Workflow\Generators
 */
class WebRouteGenerator extends ApiRouteGenerator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'route/web';

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $routeStub = 'route/route';

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {

        $return = $this->getBasePath() . '/' . $this->getConfigGeneratorClassPath($this->getClassType(), true) . '/'. 'web.php';
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


}
