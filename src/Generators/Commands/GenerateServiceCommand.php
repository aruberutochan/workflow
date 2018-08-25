<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateServiceCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:service';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Service with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * ServiceCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:service';
        parent::__construct();
    }


}
