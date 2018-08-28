<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputOption;

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
                'rule',
                null,
                InputOption::VALUE_REQUIRED ,
                'Which views is going to be generated',
                'RULE_CREATE'
            ],
            [
                'model-name',
                'm',
                InputOption::VALUE_REQUIRED,
                'The name of model for which the ' . $this->getType() . ' is being generated.',
                null
            ]
        ];

        return array_merge($parent, $return);
    }


}
