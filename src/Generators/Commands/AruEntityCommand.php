<?php
namespace Aruberuto\Workflow\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use File;
/**
 * Class EntityCommand
 * @package Prettus\Repository\Generators\Commands
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class AruEntityCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:aru-entity';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new entity.';

    /**
     * @var Collection
     */
    protected $generators = null;

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

        // $this->call('make:entity', [
        //     'name' => $this->argument('name'),
        //     '--fillable'  => $this->option('fillable'),
        //     '--rules'     => $this->option('rules'),
        //     '--validator' => $validator,
        //     '--force'     => $this->option('force')
        // ]);

        if ($this->confirm('Would you like to create a Presenter? [y|N]')) {
            $this->call('make:presenter', [
                'name'    => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);
        }

        $validator = $this->option('validator');
        if (is_null($validator) && $this->confirm('Would you like to create a Validator? [y|N]')) {
            $validator = 'yes';
        }

        if ($validator == 'yes') {
            $this->call('make:validator', [
                'name'    => $this->argument('name'),
                '--rules' => $this->option('rules'),
                '--force' => $this->option('force'),
            ]);
        }
        $service = false;
        if ($this->confirm('Would you like to create a Service? [y|N]')) {
            $service = true;
            $resource_args = [
                'name'    => $this->argument('name')
            ];

            $this->call('make:service', $resource_args);
        }

        if ($this->confirm('Would you like to create a Controller? [y|N]')) {

            $resource_args = [
                'name'    => $this->argument('name')
            ];

            if($service) {
                $controller_command = 'make:arucontroller';
            } else {
                // Generate a controller resource
                $controller_command = ((float) app()->version() >= 5.5  ? 'make:rest-controller' : 'make:resource');

            }

            $this->call($controller_command, $resource_args);

        }

        $this->call('make:repository', [
            'name'        => $this->argument('name'),
            '--fillable'  => $this->option('fillable'),
            '--rules'     => $this->option('rules'),
            '--force'     => true
        ]);
        config('repository.generator.basePath', app()->path());
        if (config('repository.generator.basePath', app()->path()) == app()->path()) {
            $this->call('make:bindings', [
                'name'    => $this->argument('name'),
                '--force' => true
            ]);
            
        } else {
            // Workaround to solve this issue https://github.com/andersao/l5-repository/issues/522
            $bindingGenerator = new \Prettus\Repository\Generators\BindingsGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force'),
            ]);
            $this->call('make:provider', [
                'name' => $bindingGenerator->getConfigGeneratorClassPath($bindingGenerator->getPathConfigNode()),
            ]);
            $path = app()->path() . '/Providers/' .  $bindingGenerator->getConfigGeneratorClassPath($bindingGenerator->getPathConfigNode()) . '.php';
            $provider = File::get($path);
            File::put($path, vsprintf(str_replace('//', '%s', $provider), [
                '//',
                $bindingGenerator->bindPlaceholder
            ]));
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
                'The name of class being generated.',
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
                'fillable',
                null,
                InputOption::VALUE_OPTIONAL,
                'The fillable attributes.',
                null
            ],
            [
                'rules',
                null,
                InputOption::VALUE_OPTIONAL,
                'The rules of validation attributes.',
                null
            ],
            [
                'validator',
                null,
                InputOption::VALUE_OPTIONAL,
                'Adds validator reference to the repository.',
                null
            ],
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ]
        ];
    }
}
