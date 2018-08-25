<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateFactoryCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:factory';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Factory with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * FactoryCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:factory';
        parent::__construct();
    }


}
