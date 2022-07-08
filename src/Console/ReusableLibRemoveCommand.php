<?php 

namespace Bjit\ReusableLib\Console;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Enums\RLRouteEnum;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class ReusableLibRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:reusable-lib-remove {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Reusable Library Folders and Files';

    protected $execCommands = [];

    protected $artisanCommands = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('force') || $this->confirm('Do you really want to remove?', false)) {
            $this->handleRemove();
            $this->info('Reusable Lib Package is removed successfully.');
        } else {
            $this->info('There is no change in Reusable Lib Package.');
        }  
    }

    protected function handleRemove()
    {
        //$this->execCommands[] = ReusableLibEnum::API_AUTH_COMPOSER_REMOVE_COMMAND[ReusableLibEnum::API_AUTH_SANCTUM];
        $this->execCommands[] = ReusableLibEnum::API_AUTH_COMPOSER_REMOVE_COMMAND[ReusableLibEnum::API_AUTH_PASSPORT];
        $this->execCommands[] = ReusableLibEnum::API_AUTH_COMPOSER_REMOVE_COMMAND[ReusableLibEnum::API_AUTH_JWT];
        $this->execCommands[] = ReusableLibEnum::OPEN_API_COMPOSER_REMOVE_COMMAND;
        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_REMOVE_IMAGE_RESIZE;
        $this->artisanCommands[] = ReusableLibEnum::BOILERPLATE_REMOVE_COMMAND;
        $this->artisanCommands[] = ReusableLibEnum::AUTHORIZATION_ARTISAN_REMOVE_COMMAND[ReusableLibEnum::ROLE_CUSTOM_TITLE];
        $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_REMOVE_BLOG;
        $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_REMOVE_CENTRALIZED_MULTIPLE_FILE;
        $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_REMOVE_NOTIFICATION;

        $this->runRemoveExecCommands();  
        $this->runRemoveArtisanCommands(); 
        $this->updateContent();
        $this->removeLanguages();
        //$this->deleteExtraDirecotriesOrFiles(); 
    }

    protected function runRemoveExecCommands()
    {
        if (function_exists('exec')) { 
            foreach ($this->execCommands as $execCommand) {
                exec('cd ' . base_path() . ' && ' . $execCommand); 
            }
            exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
            $this->info('The Commands are removed successfully.');
        } else {
            $this->error($this->prepareErrorMessage());
        } 
    }

    protected function prepareErrorMessage()
    {
        $rtrText =  "Please run below commands \n";
        if (empty($this->execCommands)) {
            return false;
        }

        foreach ($this->execCommands as $execCommand) {
            $rtrText .= $execCommand . " \n";
        }
        return $rtrText;
    }


    protected function runRemoveArtisanCommands()
    {
        foreach ($this->artisanCommands as $artisanCommand) {
            Artisan::call($artisanCommand . ' --force');
            $this->info('This ' . $artisanCommand . ' removed successfully!');
        } 
    }

    protected function updateContent()
    {
        $this->updateEnvFile();
        $this->updateRouteFile();
        $this->updateProviderFiles();
    }

    protected function updateEnvFile()
    {
        $envFile = str_replace(
            array_merge(
                ReusableLibEnum::OPEN_API_ENV_VARIABLES, 
                ['APP_NAME="' . ReusableLibEnum::APP_NAME . '"']
            ),
            array_merge(
                array_fill(ReusableLibEnum::DEFAULT_ZERO, count(ReusableLibEnum::OPEN_API_ENV_VARIABLES), ''),
                ['APP_NAME=Laravel'], 
            ),
            file_get_contents(base_path('.env'))
        ); 
        file_put_contents(base_path('.env'), $envFile);  


         
        $envFile = str_replace(
            [
                'BROADCAST_DRIVER=pusher',
                'PUSHER_APP_ID=' . ReusableLibEnum::PUSHER_APP_ID,
                'PUSHER_APP_KEY=' . ReusableLibEnum::PUSHER_APP_KEY,
                'PUSHER_APP_SECRET=' . ReusableLibEnum::PUSHER_APP_SECRET,
            ],
            ['BROADCAST_DRIVER=log', 'PUSHER_APP_ID=','PUSHER_APP_KEY=', 'PUSHER_APP_SECRET='], 
            file_get_contents(base_path('.env'))
        ); 
        file_put_contents(base_path('.env'), $envFile);
         
    }

    protected function updateRouteFile()
    {
        $routeArr = [];
        $apiRoutes = RLRouteEnum::ROUTE_API;
        foreach ($apiRoutes as $routeKey => $routeRow) {
            if ($routeKey == 'basic') {
                $routeArr = array_merge($routeArr, array_values($routeRow));
                continue;
            }

            foreach ($routeRow as $routeChildRow) {
                $routeArr = array_merge($routeArr, $routeChildRow);
            }
        } 

        $routeFile = str_replace(
            $routeArr, 
            array_fill(ReusableLibEnum::DEFAULT_ZERO, count($routeArr), ''), 
            file_get_contents(base_path('routes/api.php'))
        ); 

        file_put_contents(base_path('routes/api.php'), $routeFile); 
        $lastStr = "\n});";
        file_put_contents(base_path('routes/api.php'), $lastStr.PHP_EOL, FILE_APPEND | LOCK_EX); 
  
    }

    protected function updateProviderFiles()
    {
        $appServiceProviderFile = str_replace(
            ['App::setLocale(CmnEnum::DEFAULT_LANG);'], 
            [''], 
            file_get_contents(app_path('Providers/AppServiceProvider.php'))
        ); 
        file_put_contents(app_path('Providers/AppServiceProvider.php'), $appServiceProviderFile); 
    }

    protected function removeLanguages()
    {
        $files = $this->removeLanguageFiles();
        foreach ($files as $to) {
            if (! file_exists($filePath = $to['file'])) {  
                continue;
            } 
            (new Filesystem)->delete($filePath); 
            $mainFile = str_replace(base_path() . '/', '', $filePath);
            $this->info("This path {$mainFile} is removed successfully!");
        }

        $langDirectories = $this->removeLanguageDirectories();

        foreach ($langDirectories as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            } 
             
            (new Filesystem)->deleteDirectory($directoryPath);
            $mainPath = str_replace(base_path() . '/', '', $directoryPath);
            $this->info("This path {$mainPath} is removed successfully!");
        }  
    }
 

    protected function removeLanguageFiles()
    {
        // return [ 
        //     ['file' => base_path('resources/lang/en/messages.php')], 
        //     ['file' => base_path('resources/lang/en/mail.php')], 
        // ];

        $rtrArr = [];
        $langFiles = (new Filesystem)->files(base_path('resources/lang/en'));
        foreach ($langFiles as $langFile) { 
            if ( ! in_array($langFile->getFilename(), ReusableLibEnum::DEFAULT_LANG_FILES)) {
                $rtrArr[] = ['file' => base_path('resources/lang/en/messages.php')];
            }
        }
        return $rtrArr;
    }

    protected function removeLanguageDirectories()  
    {
        $rtrArr = [];
        foreach(ReusableLibEnum::LANGS_SHORT_FORM as $lang) {
            if($lang !== ReusableLibEnum::DEFAULT_LANG_SHORT_FORM) {
                $rtrArr[] = ['path' => base_path('resources/lang/' . $lang)];
            }
        } 
        return $rtrArr;
    }

}