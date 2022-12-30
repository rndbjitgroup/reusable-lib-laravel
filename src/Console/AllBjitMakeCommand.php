<?php 

namespace Bjit\ReusableLib\Console;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption; 

class AllBjitMakeCommand extends GeneratorCommand 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bjit-make:model';
    // protected $name = 'bjit-make:model
    // {--all : create all required files}
    // {--force : Overwrite any existing files}
    // ';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'bjit-make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all required files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';
    protected $execCommands = [];


    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle() 
    {
        //parent::handle();

        $this->handleAllFiles();

        $this->info('The files have been successfully created! ');
    }

    protected function handleAllFiles()
    {
        $options = $this->options();
        $optionals = '';
        if($options['migration']) {
            $optionals .= 'm';
        }
        if($options['factory']) {
            $optionals .= 'f';
        } 
        if($options['seed']) {
            $optionals .= 's';
        }
         
        $name = $this->argument('name'); 
        $name = str_replace('\\', '/', $name); // ADDED FOR WINDOW 
        $optionals = $optionals ? ' -'. $optionals : '';

        $this->execCommands[] = 'make:model ' . $name . $optionals;
        if ($this->option('all')) {
            $this->execCommands[] = 'make:controller Api/' . $name . 'Controller --api --model=' . $name;
            $this->execCommands[] = 'make:request ' . $name . 'StoreRequest';
            $this->execCommands[] = 'make:request ' . $name . 'UpdateRequest';
            $this->execCommands[] = 'make:request ' . $name . 'FilterRequest';
            $this->execCommands[] = 'make:resource ' . $name . 'Collection';
            $this->execCommands[] = 'make:resource ' . $name . 'Resource';
            $this->execCommands[] = 'bjit-make:repository ' . $name;
            $this->execCommands[] = 'bjit-make:service ' . $name;
        }  

        foreach ($this->execCommands as $artisanCommand) {
            Artisan::call($artisanCommand);
            $this->info('This ' . $artisanCommand . ' has been successfully installed!');
        }

        $routeName = $name;
        if (str_contains($name, '/')) {
            $routeName = explode('/', $name)[ReusableLibEnum::DEFAULT_ONE];
        }
 
        $routeStr = "\nRoute::resource('" . Str::plural(Str::lower($routeName)) .  "', \App\Http\Controllers\Api\\" . str_replace('/', '\\', $name) . "Controller::class);";
        file_put_contents(base_path('routes/api.php'), $routeStr.PHP_EOL, FILE_APPEND | LOCK_EX); 
        $this->info('This route has been successfully appended!');

    }

    /**
     * 
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return 0;
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