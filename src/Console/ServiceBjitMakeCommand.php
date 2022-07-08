<?php 

namespace Bjit\ReusableLib\Console;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ServiceBjitMakeCommand extends GeneratorCommand 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bjit-make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $serviceClass;

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $repository;
    private $repositoryNamespace;
    private $repositoryVar;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle() 
    {
        //parent::handle();
        
        $this->setServiceClass();

        $path = $this->getPath($this->serviceClass);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->serviceClass));

        $this->info($this->type.' created successfully.');

        $this->line("<info>Created Service :</info> $this->serviceClass");
    }

    /**
     * Set service class name
     *
     * @return  void
     */
    private function setServiceClass()
    {
        $name = $this->argument('name');
        $name = str_replace('/', ' ', $name);
        $name = ucwords(strtolower($name));
        $name = str_replace(' ', '/', $name);

        $this->repository = $this->parseInputName($name) . 'Repository';
        $this->repositoryNamespace = $this->parseRepositoryNamespace($name);
        $this->repositoryVariable = $this->parseRepositoryVariable();
        

        $repositoryClass = $this->parseName($name);

        //dd($name, $repositoryClass);

        $this->serviceClass = $repositoryClass . 'Service';

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument repository name");
        }

        $stub = parent::replaceClass($stub, $name);
 
        return str_replace(
            ['DummyRepositoryNamespace', 'DummyRepository', 'demoReporitoryVariable'], 
            [$this->repositoryNamespace, $this->repository, $this->repositoryVariable], 
            $stub
        );
    }

    /**
     * 
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/Service.stub';
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (str_contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
    }

    protected function parseRepositoryNamespace($name)
    {
        return str_replace([$this->parseInputName($name), '/'], [$this->repository, '\\'], $name);
    }

    protected function parseInputName($name)
    {
        if (str_contains($name, '/')) {
            preg_match("/[^\/]+$/", $name, $matches); 
            return $matches[0];
        }
        return $name;
    }

    protected function parseRepositoryVariable()
    {
        return lcfirst($this->repository);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository class.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, and resource controller for the model'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder file for the model'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['api', null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be an API controller'],
        ];
    }

}