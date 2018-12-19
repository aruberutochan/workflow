<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Aruberuto\Workflow\Generators\Commands\AbstractGenerateCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aruberuto\Workflow\Generators\ControllerGenerator;
use Aruberuto\Workflow\Generators\ApiDrivenControllerGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GenerateControllerCommand extends AbstractGenerateCommand
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'wf:generate:controller';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new Controller with Service layer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'wf:generate:controller';
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
            if($this->option('web-driven')) {
                (new ControllerGenerator(array_merge($this->arguments(), $this->options() )))->run();

            } else {
                (new ApiDrivenControllerGenerator(array_merge($this->arguments(), $this->options() )))->run();
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
                'web-driven',
                'web-driven',
                InputOption::VALUE_NONE,
                'Create a web driven controller criteria.',
                null
            ],

        ];

        return array_merge($parent, $return);
    }


}
