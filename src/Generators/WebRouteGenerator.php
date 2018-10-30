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


}
