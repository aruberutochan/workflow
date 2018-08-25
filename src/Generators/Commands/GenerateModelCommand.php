<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
class GenerateModelCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:model';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Model with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * ModelCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:model';
        parent::__construct();
    }

}
