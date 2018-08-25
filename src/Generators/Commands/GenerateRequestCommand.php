<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateRequestCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:request';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Request with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * RequestCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:request';
        parent::__construct();
    }


}
