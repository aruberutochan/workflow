<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateSeederCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:seeder';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Seeder with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * SeederCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:seeder';
        parent::__construct();
    }


}
