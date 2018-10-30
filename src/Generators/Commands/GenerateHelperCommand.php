<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateHelperCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:helper';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Helper.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Helper';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:helper';
        parent::__construct();
    }

}
