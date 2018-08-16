<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Aruberuto\Workflow\Generators\EntityGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateWorkflowEntityCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:workflow';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Workflow complete Entity with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Workflow';

    /**
     * EntityCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:workflow';
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

    public function sameOptionsAndArguments() {
        $result = [];
        foreach($this->arguments() as $argument => $value ) {
            $result[$argument] = $value;
        }
        foreach($this->options() as $option => $value ) {
            $result['--' . $option] = $value;
        }

        return $result;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            // // Generate create request for entity
            // $this->call('generate:request', [
            //     'name' => $this->argument('name') . 'Create',
            //     'path' => $this->option('path') . '/Requests'
            // ]);

            // // Generate update request for entity
            // $this->call('make:aru-request', [
            //     'name' => $this->argument('name') . 'Update',
            //     'path' => $this->option('path') . '/Requests'
            // ]);
            $sameArguments = $this->sameOptionsAndArguments();

            $updateRequestArguments = $sameArguments;
            $createRequestArguments = $sameArguments;
            $metadataMigrationArguments = $sameArguments;

            $updateRequestArguments['name'] = $this->argument('name') . 'Update';
            $createRequestArguments['name'] = $this->argument('name') . 'Create';
            $metadataMigrationArguments['--metadata'] = true;

            $this->call('wf:generate:controller', $sameArguments);
            $this->call('wf:generate:criteria', $sameArguments);
            $this->call('wf:generate:model', $sameArguments);
            $this->call('wf:generate:presenter', $sameArguments);
            $this->call('wf:generate:migration', $sameArguments);
            $this->call('wf:generate:migration', $metadataMigrationArguments);

            $this->call('wf:generate:request', $updateRequestArguments);
            $this->call('wf:generate:request', $createRequestArguments);

            $this->call('wf:generate:service', $sameArguments);
            $this->call('wf:generate:transformer', $sameArguments);
            $this->call('wf:generate:validator', $sameArguments);

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
                'The http base path where the entity will be generated.',
                config('workflow.http', '/Http'),

            ],
            [
                'root-namespace',
                'r',
                InputOption::VALUE_REQUIRED,
                'The base namespace of the generated files',
                config('workflow.rootNamespace', 'App\\'),

            ],

        ];
    }
}
