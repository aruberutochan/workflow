<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Aruberuto\Workflow\Generators\MigrationGenerator;
use Aruberuto\Workflow\Generators\MetadataMigrationGenerator;
use Symfony\Component\Console\Input\InputOption;
class GenerateMigrationCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:migration';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Migration with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * MigrationCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:migration';
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
            // // Generate create request for migration
            // $this->call('generate:request', [
            //     'name' => $this->argument('name') . 'Create',
            //     'path' => $this->option('path') . '/Requests'
            // ]);

            // // Generate update request for migration
            // $this->call('make:aru-request', [
            //     'name' => $this->argument('name') . 'Update',
            //     'path' => $this->option('path') . '/Requests'
            // ]);
            if($this->option('metadata')) {
                (new MetadataMigrationGenerator(array_merge($this->arguments(), $this->options() )))->run();
            } else {
                (new MigrationGenerator(array_merge($this->arguments(), $this->options() )))->run();
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
                'metadata',
                'meta',
                InputOption::VALUE_NONE,
                'Create a metadata migration.',
                null
            ],

        ];

        return array_merge($parent, $return);
    }
}
