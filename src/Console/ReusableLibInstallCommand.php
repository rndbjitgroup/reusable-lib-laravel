<?php 

namespace Bjit\ReusableLib\Console;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Enums\RLRouteEnum;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;

class ReusableLibInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:reusable-lib-install {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Reusable Library step by step';

    protected $selectedLangs = [];
    protected $execCommands = [];
    protected $artisanCommands = [];
    protected $lastCommands = [];
    protected $chosenRoutes = [];
    protected $selectedApiAuth = '';
    protected $selectedCase = 'snack_case';
    protected $isPushNotification = false;
    protected $selectedNotificationOptions = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleInstallation();
    }

    protected function isDatabaseConnected()
    {
        try {
            if(DB::connection()->getPdo()) {
                $this->info('Connected successfully to database ' . DB::connection()->getDatabaseName());
            }   
        } catch (Exception $e) {
            $this->error('You are not connected to database. Please connect with database.');
            $this->error($e->getMessage());
            exit;
        }
    }

    protected function handleInstallation()
    {
        $langArr = ReusableLibEnum::LANGS;
        $notificationTypes = ReusableLibEnum::NOTIFICATION_TYPES;
        $this->selectedLangs = [ReusableLibEnum::DEFAULT_LANG];
        //$this->isDatabaseConnected();
        if ($this->confirm('Is this an API-based app?', true)) {
            
            if ($this->confirm('Will this application be camel case enabled for requests and responses?', true)) {
                $this->selectedCase = ReusableLibEnum::CAMEL_CASE;
            }

            $result = $this->choice( 'Please choose one of the following API authentication methods:', ReusableLibEnum::API_AUTHS, ReusableLibEnum::DEFAULT_ZERO );
            
            $this->selectedApiAuth = $result;

            if ($result !== ReusableLibEnum::API_AUTH_NONE) {
                $this->isDatabaseConnected();
            }

            $this->artisanCommands[] = ReusableLibEnum::BOILERPLATE_COMMAND . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase;
            $this->chosenRoutes[] = RLRouteEnum::ROUTE_BOILERPLATE;

            if ($result == ReusableLibEnum::API_AUTH_PASSPORT) {
                //$this->lastCommands[] = ReusableLibEnum::ARTISAN_PASSPORT_COMMAND; // No Need to run this command for Laravel 11
                $this->lastCommands[] = ReusableLibEnum::ARTISAN_PASSPORT_CLIENT_PERSONAL_COMMAND;
            }

            $result = $this->choice( 'Please choose the localization language and type the default language first (example: 1 or 1, 0, 2):', $langArr, ReusableLibEnum::DEFAULT_ZERO, null, true );
            if ($result !== ReusableLibEnum::LANG_NA) {
                $this->selectedLangs = $result; 
            }
            
            if ($this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE && $this->confirm('Are roles and permissions module needed in this application?', true)) {
                $this->artisanCommands[] = ReusableLibEnum::AUTHORIZATION_ARTISAN_COMMAND[ReusableLibEnum::DEFAULT_ROLE_AND_PERMISSION] . ' --case=' . $this->selectedCase;
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE;
            }

            if ($this->confirm('Is the simple blog module needed in this application?', true)) { 
                $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_BLOG . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase;
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_BLOG;
            }

            if ($this->confirm('Is the centralized multiple file module needed in this application?', true)) { 
                $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_CENTRALIZED_MULTIPLE_FILE . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase;
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_CENTRALIZED_MULTIPLE_FILE;
            }

            $result = $this->choice( 'Please choose the notification type that is used by this application (example: 0 or 0, 1, 2):', $notificationTypes, ReusableLibEnum::DEFAULT_ZERO, null, true );
             
            if ($result) { 
                $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_NOTIFICATION . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase  . ' --notification_types=' . base64_encode(json_encode($result));
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_NOTIFICATION_SYSTEM;
                $this->selectedNotificationOptions = $result;

                if (in_array( ReusableLibEnum::NOTIFICATION_PUSH, $result)) { 
                    $this->isPushNotification = true;
                }
            }

        } else {
            $this->info('Sorry! There is no support at the moment!');
            return false;
        } 

        $this->checkAndSetAPIRoute();
        $this->appendRoute(); 
        
        $this->appendEnv();
        $this->runExecCommands();  
        $this->runArtisanCommands(); 
        $this->updateConfig();
        $this->runLastArtisanCommands();
        $this->installLanguages(); 
        
        $this->info('The reusable library has been successfully installed.');
    }

    protected function runExecCommands($paramCommands = [])
    {
        if (function_exists('exec')) { 
            $execCommands = !empty($paramCommands) ? $paramCommands : $this->execCommands; 
            foreach ($execCommands as $execCommand) {
                exec('cd ' . base_path() . ' && ' . $execCommand); 
            }
            exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
            $this->info('The commands have been run successfully.');
        } else {
            $this->error($this->prepareErrorMessage());
        } 
    }

    protected function prepareErrorMessage()
    {
        $rtrText =  "Please run the below commands: \n";
        if(empty($this->execCommands)) {
            return false;
        }

        foreach ($this->execCommands as $execCommand) {
            $rtrText .= $execCommand . " \n";
        }
        return $rtrText;
    }

    protected function runArtisanCommands()
    {
        foreach ($this->artisanCommands as $artisanCommand) {
            Artisan::call($artisanCommand);
            $this->info('This ' . $artisanCommand . ' has been successfully installed!');
        } 
    }


    protected function checkAndSetAPIRoute()
    { 
        if (!file_exists(base_path('routes/api.php'))) {
            $files = $this->commonFiles();
            foreach ($files as $from => $to) { 
                if (! is_dir($stubsPath = $to['path'])) {  
                    (new Filesystem)->makeDirectory($stubsPath, 0777, true);
                }  
                if (! file_exists($to['file']) || $this->option('force')) {
                        $from = file_get_contents($from);
                        file_put_contents($to['file'], $from);
                        $mainFile = str_replace(base_path() . '/', '', $to['file']);
                        $this->info("This file {$mainFile} is installed successfully!");
                }
            } 
        }
    }

    protected function appendRoute()
    {
        $gRouteStr = RLRouteEnum::ROUTE_API['basic']['group_start'];
        $routeStr = '';
        $waRouteStr = '';
        foreach ($this->chosenRoutes as $chosenRoute) {
            
            if ($chosenRoute == RLRouteEnum::ROUTE_BOILERPLATE) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_BOILERPLATE]['without_auth'] as $bwAuthRow) {
                    //$routeStr .=  $bwAuthRow;
                    $waRouteStr .=  $bwAuthRow;
                }

                // if ( $this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE ) {
                //     if (in_array(RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE, $this->chosenRoutes)) {
                //         $routeStr .=  RLRouteEnum::ROUTE_API['basic']['auth_start'];
                //     } else {
                //         $routeStr .=  RLRouteEnum::ROUTE_API['basic']['auth_start_without_auth_gate'];
                //     }
                // }

                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_BOILERPLATE]['auth'] as $bAuthRow) {
                    if ( $this->selectedApiAuth === ReusableLibEnum::API_AUTH_NONE 
                        && (strpos($bAuthRow, 'update-profile') !== false || strpos($bAuthRow, 'change-password') !== false || strpos($bAuthRow, 'logout') !== false )) {
                        continue;
                    }
                    $routeStr .= $bAuthRow;
                }
            }
            
            if ($chosenRoute == RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE]['auth'] as $cprAuthRow) {
                    $routeStr .=  $cprAuthRow;
                }
            }

            if ($chosenRoute == RLRouteEnum::ROUTE_BLOG) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_BLOG]['auth'] as $sbAuthRow) {
                    $routeStr .=  $sbAuthRow;
                }
            }

            if ($chosenRoute == RLRouteEnum::ROUTE_CENTRALIZED_MULTIPLE_FILE) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_CENTRALIZED_MULTIPLE_FILE]['auth'] as $sbAuthRow) {
                    $routeStr .=  $sbAuthRow;
                }
            }

            if ($chosenRoute == RLRouteEnum::ROUTE_NOTIFICATION_SYSTEM) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_NOTIFICATION_SYSTEM]['without_auth'] as $sbWAuthKey => $sbWAuthRow) {
                    //$this->info($sbWAuthKey . ' --- ' .$sbWAuthRow); 
                    if (in_array(ReusableLibEnum::NOTIFICATION_EMAIL, $this->selectedNotificationOptions) && $sbWAuthKey == ReusableLibEnum::DEFAULT_ZERO) {
                        $waRouteStr .=  $sbWAuthRow;
                    }

                    if (in_array(ReusableLibEnum::NOTIFICATION_DATABASE, $this->selectedNotificationOptions) && $sbWAuthKey == ReusableLibEnum::DEFAULT_ONE) {
                        $waRouteStr .=  $sbWAuthRow;
                    }
                    
                    if (in_array(ReusableLibEnum::NOTIFICATION_EMAIL, $this->selectedNotificationOptions) 
                        && in_array(ReusableLibEnum::NOTIFICATION_DATABASE, $this->selectedNotificationOptions)
                        && $sbWAuthKey == ReusableLibEnum::DEFAULT_TWO) {
                        $waRouteStr .=  $sbWAuthRow;
                    }

                    if (in_array( ReusableLibEnum::NOTIFICATION_PUSH, $this->selectedNotificationOptions) && $sbWAuthKey == ReusableLibEnum::DEFAULT_THREE) {
                        $waRouteStr .=  $sbWAuthRow;
                    }

                }
            }
        }

        $gRouteStr .= $waRouteStr;

        if ( $this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE ) {
            if (in_array(RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE, $this->chosenRoutes)) {
                $gRouteStr .= RLRouteEnum::ROUTE_API['basic']['auth_start'];
            } else {
                $gRouteStr .= RLRouteEnum::ROUTE_API['basic']['auth_start_without_auth_gate'];
            }
        }

        $gRouteStr .= $routeStr;
        
        if ( $this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE ) {
            $gRouteStr .= RLRouteEnum::ROUTE_API['basic']['auth_end'];
        }
        
        $gRouteStr .= RLRouteEnum::ROUTE_API['basic']['group_end'];
         
        file_put_contents(base_path('routes/api.php'), $gRouteStr.PHP_EOL, FILE_APPEND | LOCK_EX); 
        $this->info('This route has been successfully appended!');
    }

    protected function updateConfig()
    {
        if (file_exists(config_path('l5-swagger.php'))) {
            $swaggerConfigFile = str_replace(
                array_keys(ReusableLibEnum::OPEN_API_CONFIG_TEXTS), 
                array_values(ReusableLibEnum::OPEN_API_CONFIG_TEXTS),
                file_get_contents(config_path('l5-swagger.php'))
            ); 
            file_put_contents(config_path('l5-swagger.php'), $swaggerConfigFile);
            $this->info("This l5-swagger.php file has been successfully updated!\n");
        }
    }

    protected function appendEnv()
    {
        if( ! file_exists(base_path('.env'))) {
            $this->error('The .env file is missing.'); 
            exit;
        }
        $envStr = '';
        foreach (ReusableLibEnum::OPEN_API_ENV_VARIABLES as $variable) {
            $envStr .= $variable;
        }

        if (!empty($envStr)) {  
            file_put_contents(base_path('.env'), $envStr.PHP_EOL, FILE_APPEND | LOCK_EX); 
        }  

        $envFile = str_replace(
            ['APP_NAME=Laravel'], 
            ['APP_NAME="' . ReusableLibEnum::APP_NAME . '"'],
            file_get_contents(base_path('.env'))
        ); 
        file_put_contents(base_path('.env'), $envFile);

        /*
        if($this->isPushNotification) { 
            // $envFile = str_replace(
            //     [
            //         'BROADCAST_DRIVER=log',
            //         'PUSHER_APP_ID=',
            //         'PUSHER_APP_KEY=', 
            //         'PUSHER_APP_SECRET=', 
            //         ReusableLibEnum::PUSHER_APP_KEY . '"'
            //     ], 
            //     [
            //         'BROADCAST_DRIVER=pusher',
            //         'PUSHER_APP_ID=' . ReusableLibEnum::PUSHER_APP_ID,
            //         'PUSHER_APP_KEY=' . ReusableLibEnum::PUSHER_APP_KEY,
            //         'PUSHER_APP_SECRET=' . ReusableLibEnum::PUSHER_APP_SECRET,
            //         '"'
            //     ],
            //     file_get_contents(base_path('.env'))
            // ); 
            $envFile = str_replace(
                [
                    'BROADCAST_CONNECTION=log',
                    'REVERB_APP_ID=',
                    'REVERB_APP_KEY=', 
                    'REVERB_APP_SECRET=', 
                    ReusableLibEnum::REVERB_APP_KEY . '"'
                ], 
                [
                    'BROADCAST_CONNECTION=reverb',
                    'REVERB_APP_ID=' . ReusableLibEnum::REVERB_APP_ID,
                    'REVERB_APP_KEY=' . ReusableLibEnum::REVERB_APP_KEY,
                    'REVERB_APP_SECRET=' . ReusableLibEnum::REVERB_APP_SECRET,
                    '"'
                ],
                file_get_contents(base_path('.env'))
            );
            file_put_contents(base_path('.env'), $envFile);
        }*/

    }

    protected function runLastArtisanCommands()
    {
        $lastArtisanCommandsArr[] = array_merge(
            [ReusableLibEnum::ARTISAN_MIGRATE_FRESH], 
            $this->lastCommands
        );
        $this->withProgressBar($lastArtisanCommandsArr, function ($lastArtisanCommands) {
            $this->runExecCommands($lastArtisanCommands);
        });
        $this->info("\n");
    }

    protected function installLanguages()
    {
        //--- UPDATE AppServiceProvider FILE
        file_put_contents(
            app_path('Providers/AppServiceProvider.php'), 
            file_get_contents(__DIR__ . '/stubs/Common/Providers/AppServiceProvider.stub')
        );
        $this->info('This app/Providers/AppServiceProvider.php file is updated successfully!');

        //--- UPDATE CmnEnum.php FILE 
        $defaultLang = ReusableLibEnum::LANGS_SHORT_FORM[$this->selectedLangs[ReusableLibEnum::DEFAULT_ZERO]];
        $cmnEnum = str_replace(
            ["DEFAULT_LANG = 'en';"], 
            ["DEFAULT_LANG = '" . $defaultLang . "';"], 
            file_get_contents(app_path('Enums/CmnEnum.php'))
        ); 
        file_put_contents(app_path('Enums/CmnEnum.php'), $cmnEnum); 
        $this->info('This app/Enums/CmnEnum.php file is updated successfully!');

        //--- INSTALL LANG FILES 
        if ($this->selectedLangs) {
            foreach ($this->selectedLangs as $selectedLang) {
                $selectedShortLang = ReusableLibEnum::LANGS_SHORT_FORM[$selectedLang];
                $stubPath = __DIR__ . '/stubs/Common/resources/lang/' . $selectedShortLang;
                $appLangPath = 'resources/lang/' . $selectedShortLang;
        
                if ( ! is_dir(base_path($appLangPath))) {  
                    (new Filesystem)->makeDirectory(base_path($appLangPath), 0777, true);
                }
                $langFiles = (new Filesystem)->files($stubPath);
                foreach ($langFiles as $langFile) { 
                    file_put_contents(
                        base_path($appLangPath . '/' . str_replace('.stub', '.php', $langFile->getFilename())), 
                        file_get_contents($stubPath . '/' . $langFile->getFilename()) 
                    );
                } 
                $this->info('This resources/lang/' . $selectedShortLang .  ' files have been successfully installed!');
            }
        }
         
    }  

    protected function commonFiles()
    {  
        $rtrArr = [
            __DIR__ . '/stubs/Boilerplate/Auth/Routes/api.stub' => [
                'path' => base_path('routes'), 'file' => base_path('routes').'/api.php'
            ], 
        ]; 
        return $rtrArr;
    }

}