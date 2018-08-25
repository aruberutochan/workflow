<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Aruberuto\Workflow\Generators\ResourceCollectionGenerator;
use Aruberuto\Workflow\Generators\ResourceGenerator;

use Symfony\Component\Console\Input\InputOption;

class GenerateResourceCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:resource';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Resource with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    /**
     * ResourceCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:resource';
        parent::__construct();
    }

        /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            // // Generate create request for resource
            // $this->call('generate:request', [
            //     'name' => $this->argument('name') . 'Create',
            //     'path' => $this->option('path') . '/Requests'
            // ]);

            // // Generate update request for resource
            // $this->call('make:aru-request', [
            //     'name' => $this->argument('name') . 'Update',
            //     'path' => $this->option('path') . '/Requests'
            // ]);
            if($this->option('collection')) {
                (new ResourceCollectionGenerator(array_merge($this->arguments(), $this->options() )))->run();

            } else {
                (new ResourceGenerator(array_merge($this->arguments(), $this->options() )))->run();
            }
            if($this->option('remove')) {
                $this->info($this->type . ' remove successfully.');
            } else {
                $this->info($this->type . ' created successfully.');
            }

        } catch (FileAlreadyExistsException $e) {

            $this->error($this->type . ' already exists!');

            return false;
        } catch (FileNotFoundException $e) {

            $this->error($this->type . ' not found!');

            return false;
        }
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
                'collection',
                'c',
                InputOption::VALUE_NONE,
                'Create a collection resource',
                null
            ],

        ];

        return array_merge($parent, $return);
    }
}
