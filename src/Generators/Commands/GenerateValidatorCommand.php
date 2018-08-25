<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateValidatorCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:validator';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Validator with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Validator';

    /**
     * ValidatorCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:validator';
        parent::__construct();
    }

}
