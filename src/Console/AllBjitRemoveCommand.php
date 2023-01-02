<?php 

namespace Bjit\ReusableLib\Console;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption; 

class AllBjitRemoveCommand extends GeneratorCommand 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'bjit-remove:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'all';
    protected $execCommands = [];


    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle() 
    {
        //parent::handle();
        
        $this->handleRemoveFiles();
        $this->deleteMigrationFiles();
        $this->removeDirectories();
        $this->updatedContent();

        $this->info('All files have been successfully removed!');
    }

    protected function handleRemoveFiles()
    {
        $files = $this->removeFlieList();
        foreach ($files as $to) {
            if (! file_exists($filePath = $to['file'])) {  
                continue;
            } 
            (new Filesystem)->delete($filePath); 
            $mainFile = str_replace(base_path() . '/', '', $filePath);
            $this->info("This path {$mainFile} has been successfully removed!");
        } 

    } 

    protected function removeFlieList()
    {
        $name = $this->removeBackslash($this->argument('name'));
        $specificName = $name;
        if (str_contains($name, '/')) {
            $specificName = explode('/', $name)[ReusableLibEnum::DEFAULT_ONE];
        }

        return [
            //['file' => app_path('Models/BaseModel.php')], 
            ['file' => app_path('Models/' . $name . '.php')],  
            ['file' => app_path('Repositories/' . $name . 'Repository.php')],  
            ['file' => app_path('Services/' . $name . 'Service.php')],  
            ['file' => app_path('Http/Resources/' . $name . 'Collection.php')], 
            ['file' => app_path('Http/Resources/' . $name . 'Resource.php')], 
            ['file' => app_path('Http/Controllers/Api/' . $name . 'Controller.php')],  
            ['file' => app_path('Http/Requests/' . $name . 'FilterRequest.php')],  
            ['file' => app_path('Http/Requests/' . $name . 'StoreRequest.php')],
            ['file' => app_path('Http/Requests/' . $name . 'UpdateRequest.php')],
            ['file' => base_path('database/factories/' . $name . 'Factory.php')],
            ['file' => base_path('database/seeders/' . $specificName . 'Seeder.php')],
        ];
    }

    protected function deleteMigrationFiles()
    {
        $files = (new Filesystem)->files(base_path('database/migrations'));
        if (!empty($files ) && count($files) > 0) {
            foreach ($files as $file) { 
                if ($this->isMigrationFileExists($file)) {
                    (new Filesystem)->delete($file->getPathname());  
                    $mainFile = str_replace(base_path() . '/', '', $file->getPathname());
                    $this->info("This file {$mainFile} has been successfully removed!");
                }
            } 
        }
    }

    protected function isMigrationFileExists($file)
    {
        $deleteFileNames = $this->migrationFileNames();
        
        $fileName = substr($file->getFilename(), ReusableLibEnum::MIGRATION_DATE_STRING_LAST_POS);

        if (isset($deleteFileNames[$fileName])) {
            return true;
        }
        return false;
    }

    protected function migrationFileNames()
    {
        $name = $this->removeBackslash($this->argument('name'));
        $specificName = $name;
        if (str_contains($name, '/')) {
            $specificName = explode('/', $name)[ReusableLibEnum::DEFAULT_ONE];
        }

        $specificName = Str::plural(Str::lower($specificName));

        return [
            'create_' . $specificName . '_table.php' => 'create_' . $specificName . '_table.php',
        ];
    }

    protected function removeDirectories()
    {
        $directories = $this->removeDirectoryList();
        foreach ($directories as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            }   
            if (count((new Filesystem)->files($directoryPath)) == ReusableLibEnum::DEFAULT_ZERO) {
                (new Filesystem)->deleteDirectory($directoryPath);
                $mainPath = str_replace(base_path() . '/', '', $directoryPath);
                $this->info("This path {$mainPath} has been successfully removed!");
            }
        }
    }

    protected function removeDirectoryList()
    {
        $name = $this->removeBackslash($this->argument('name'));
        $dirName = '';
        if (str_contains($name, '/')) {
            $dirName = '/' . explode('/', $name)[ReusableLibEnum::DEFAULT_ZERO];
        }

        return [
            ['path' => app_path('Models' . $dirName)],
            ['path' => app_path('Repositories' . $dirName)],
            ['path' => app_path('Services' . $dirName)],
            ['path' => app_path('Http/Resources' . $dirName)],
            ['path' => app_path('Http/Controllers/Api' . $dirName)],
            ['path' => app_path('Http/Requests' . $dirName)],
            ['path' => base_path('database/factories' . $dirName)], 
        ];
    }

    protected function updatedContent()
    {
        $name = $this->removeBackslash($this->argument('name'));
        $routeName = $name;
        if (str_contains($name, '/')) {
            $routeName = explode('/', $name)[ReusableLibEnum::DEFAULT_ONE];
        }
        $routeStr = "\nRoute::resource('" . Str::plural(Str::lower($routeName)) .  "', \App\Http\Controllers\Api\\" . str_replace('/', '\\', $name) . "Controller::class);";
        
        $routeFile = str_replace(
                        [$routeStr], 
                        [''],
                        file_get_contents(base_path('routes/api.php'))
                    ); 
        
        file_put_contents(base_path('routes/api.php'), $routeFile); 
        $this->info('This route has been successfully updated!');
    }

    private function removeBackslash($name)
    {
        return str_replace('\\', '/', $name); // ADDED FOR WINDOW 
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