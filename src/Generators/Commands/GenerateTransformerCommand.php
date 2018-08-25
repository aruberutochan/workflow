<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateTransformerCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:transformer';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Transformer with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Transformer';

    /**
     * TransformerCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:transformer';
        parent::__construct();
    }


}
