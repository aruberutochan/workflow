<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputOption;
use Aruberuto\Workflow\Generators\AncestorCriteriaGenerator;
use Aruberuto\Workflow\Generators\CriteriaGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;

class GenerateCriteriaCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:criteria';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Criteria with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Criteria';

    /**
     * CriteriaCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:criteria';
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
            if($this->option('ancestor')) {
                (new AncestorCriteriaGenerator(array_merge($this->arguments(), $this->options() )))->run();

            } else {
                (new CriteriaGenerator(array_merge($this->arguments(), $this->options() )))->run();
            }
            if($this->option('remove')) {
                $this->info($this->type . ' remove successfully.');
            } else {
                $this->info($this->type . ' created successfully.');
            }

        } catch (FileAlreadyExistsException $e) {

            $this->warn($this->type . ' already exists!');

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
                'ancestor',
                'ancestor',
                InputOption::VALUE_NONE,
                'Create an ancestor criteria.',
                null
            ],

        ];

        return array_merge($parent, $return);
    }

}
