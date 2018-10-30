<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aruberuto\Workflow\Generators\WebRouteGenerator;
use Aruberuto\Workflow\Generators\ApiRouteGenerator;
class GenerateRouteCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:route';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new routes.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:route';
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

            if($this->option('web')) {
                (new WebRouteGenerator(array_merge($this->arguments(), $this->options() )))->run();
            } else {
                (new ApiRouteGenerator(array_merge($this->arguments(), $this->options() )))->run();
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
                'web',
                '',
                InputOption::VALUE_NONE,
                'Create a web route.',
                null
            ],

        ];

        return array_merge($parent, $return);
    }
}
