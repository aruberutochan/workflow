<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateControllerCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:controller';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Controller with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:controller';
        parent::__construct();
    }

}
