<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GeneratePresenterCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:presenter';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Presenter with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Presenter';

    /**
     * PresenterCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:presenter';
        parent::__construct();
    }


}
