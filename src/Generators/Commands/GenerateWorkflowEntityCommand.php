<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;

class GenerateWorkflowEntityCommand extends AbstractGenerateCommand
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

    public function sameOptionsAndArguments() {
        $result = [];
        foreach($this->arguments() as $argument => $value ) {
            if($value) {
                $result[$argument] = $value;
            }
        }
        foreach($this->options() as $option => $value ) {
            if($value) {
                $result['--' . $option] = $value;
            }
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

            $sameArguments = $this->sameOptionsAndArguments();

            $updateRequestArguments = $sameArguments;
            $createRequestArguments = $sameArguments;
            $metadataMigrationArguments = $sameArguments;
            $resourceCollectionArguments = $sameArguments;

            $updateRequestArguments['name'] = $this->argument('name') . 'Update';
            $createRequestArguments['name'] = $this->argument('name') . 'Create';
            $metadataMigrationArguments['--metadata'] = true;
            $resourceCollectionArguments['--collection'] = true;

            $this->call('wf:generate:controller', $sameArguments);
            $this->call('wf:generate:repository', $sameArguments);

            $this->call('wf:generate:criteria', $sameArguments);
            $this->call('wf:generate:model', $sameArguments);

            $this->call('wf:generate:migration', $sameArguments);
            $this->call('wf:generate:migration', $metadataMigrationArguments);

            $this->call('wf:generate:seeder', $sameArguments);
            $this->call('wf:generate:factory', $sameArguments);

            $this->call('wf:generate:request', $updateRequestArguments);
            $this->call('wf:generate:request', $createRequestArguments);

            $this->call('wf:generate:service', $sameArguments);

            // $this->call('wf:generate:presenter', $sameArguments);
            // $this->call('wf:generate:transformer', $sameArguments);

            $this->call('wf:generate:resource', $sameArguments);
            $this->call('wf:generate:resource', $resourceCollectionArguments);

            $this->call('wf:generate:validator', $sameArguments);
            $this->call('wf:generate:view', $sameArguments);



            if($this->option('remove')) {
                $this->info($this->type . ' remove successfully.');
            } else {
                $this->call('wf:generate:provider', $sameArguments);
                $this->info($this->type . ' created successfully.');
            }

        } catch (FileAlreadyExistsException $e) {

            $this->error($this->type . ' already exists!');

            return false;
        }
    }

}
