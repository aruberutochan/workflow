<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractGenerateCommand extends Command
{

    public function __construct()
    {
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

    public function getType() {
        return $this->type;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            $className = 'Aruberuto\\Workflow\\Generators\\' . $this->getType() . 'Generator';

            (new $className(array_merge($this->arguments(), $this->options() )))->run();

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
                'The name of model for which the ' . $this->getType() . ' is being generated.',
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
                'remove',
                null,
                InputOption::VALUE_NONE,
                'Remove the created files and directories if files exist.',
                null
            ],
            [
                'path',
                'p',
                InputOption::VALUE_REQUIRED,
                'The http base path where the controller will be generated.',
                null

            ],
            [
                'root-namespace',
                'r',
                InputOption::VALUE_REQUIRED,
                'The base namespace of the generated files',
                config('workflow.rootNamespace', 'App'),

            ]


        ];
    }
}
