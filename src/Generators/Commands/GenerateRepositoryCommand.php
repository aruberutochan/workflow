<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateRepositoryCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:repository';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Repository with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * RepositoryCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:repository';
        parent::__construct();
    }


}
