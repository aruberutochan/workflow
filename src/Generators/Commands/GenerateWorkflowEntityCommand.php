<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputOption;
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
            unset($sameArguments['--src']);

            $srcSameArguments = $sameArguments;
            $srcSameArguments['--src'] =  $this->option('src') === 'no' || $this->option('src') === 'false' ? false : true;

            $updateRequestArguments = $srcSameArguments;
            $createRequestArguments = $srcSameArguments;
            $metadataMigrationArguments = $sameArguments;
            $resourceCollectionArguments = $srcSameArguments;
            $ancestorCriteriaArguments = $srcSameArguments;
            $ancestorCriteriaArguments['--ancestor'] = true;

            $updateRequestArguments['name'] = $this->argument('name') . 'Update';
            $updateRequestArguments['--rule'] = 'RULE_UPDATE';
            $updateRequestArguments['--model-name'] = $this->argument('name');


            $createRequestArguments['name'] = $this->argument('name') . 'Create';
            $createRequestArguments['--model-name'] = $this->argument('name');

            $metadataMigrationArguments['--metadata'] = true;
            $resourceCollectionArguments['--collection'] = true;

            $this->call('wf:generate:controller', $srcSameArguments);
            $this->call('wf:generate:repository', $srcSameArguments);

            $this->call('wf:generate:criteria', $srcSameArguments);
            $this->call('wf:generate:criteria', $ancestorCriteriaArguments);

            $this->call('wf:generate:model', $srcSameArguments);

            $this->call('wf:generate:migration', $sameArguments);
            $this->call('wf:generate:migration', $metadataMigrationArguments);

            $this->call('wf:generate:seeder', $sameArguments);
            $this->call('wf:generate:factory', $sameArguments);

            $this->call('wf:generate:request', $updateRequestArguments);
            $this->call('wf:generate:request', $createRequestArguments);

            $this->call('wf:generate:service', $srcSameArguments);

            // $this->call('wf:generate:presenter', $srcSameArguments);
            // $this->call('wf:generate:transformer', $srcSameArguments);

            $this->call('wf:generate:resource', $srcSameArguments);
            $this->call('wf:generate:resource', $resourceCollectionArguments);

            // $this->call('wf:generate:validator', $srcSameArguments);
            $this->call('wf:generate:view', $sameArguments);
            $this->call('wf:generate:helper', $srcSameArguments);
            $this->call('wf:generate:route', $sameArguments);

            $webRouteArguments = $sameArguments;
            $webRouteArguments['--web'] = true;
            $this->call('wf:generate:route', $webRouteArguments);






            if($this->option('remove')) {
                $this->info($this->type . ' remove successfully.');
            } else {
                $this->call('wf:generate:provider', $srcSameArguments);
                $this->info($this->type . ' created successfully.');
            }

        } catch (FileAlreadyExistsException $e) {

            $this->error($this->type . ' already exists!');

            return false;
        }
    }

}
