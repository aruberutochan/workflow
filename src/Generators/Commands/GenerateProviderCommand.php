<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateProviderCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:provider';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Provider with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * ProviderCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:provider';
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle(){
        $this->laravel->call([$this, 'fire'], func_get_args());
    }


}
