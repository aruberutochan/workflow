<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateCriteriaCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:criteria';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Criteria with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Criteria';

    /**
     * CriteriaCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:criteria';
        parent::__construct();
    }

}
