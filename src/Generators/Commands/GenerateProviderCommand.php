<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Aruberuto\Workflow\Generators\ProviderGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateProviderCommand extends Command
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

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            // // Generate create request for provider
            // $this->call('generate:request', [
            //     'name' => $this->argument('name') . 'Create',
            //     'path' => $this->option('path') . '/Requests'
            // ]);

            // // Generate update request for provider
            // $this->call('make:aru-request', [
            //     'name' => $this->argument('name') . 'Update',
            //     'path' => $this->option('path') . '/Requests'
            // ]);

            (new ProviderGenerator(array_merge($this->arguments(), $this->options() )))->run();

            $this->info($this->type . ' created successfully.');

        } catch (FileAlreadyExistsException $e) {

            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of model for which the Service is being generated.',
                null
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
            [
                'path',
                'p',
                InputOption::VALUE_REQUIRED,
                'The http base path where the provider will be generated.',
                null

            ],
            [
                'root-namespace',
                'r',
                InputOption::VALUE_REQUIRED,
                'The base namespace of the generated files',
                config('workflow.rootNamespace', 'App'),

            ],

        ];
    }
}
