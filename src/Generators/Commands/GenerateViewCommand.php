<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputOption;

class GenerateViewCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:view';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new View with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * ViewCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:view';
        parent::__construct();
    }

        /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        $parent = parent::getOptions();
        $return = [
            [
                'views',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Which views is going to be generated',
                array('index', 'create', 'edit', 'show'),
            ]
        ];

        return array_merge($parent, $return);
    }
}
