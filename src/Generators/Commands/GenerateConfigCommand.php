<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;
use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
class GenerateConfigCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:config';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Config with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Config';

    /**
     * ModelCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:config';
        parent::__construct();
    }

    public function getOptions()
    {
        $parent = parent::getOptions();
        $return = [

            [
                'entity',
                '',
                InputOption::VALUE_REQUIRED,
                'Create option for entity class',
                null
            ],

        ];

        return array_merge($parent, $return);
    }

}
