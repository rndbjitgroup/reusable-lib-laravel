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
        $this->selectedLangs = [ReusableLibEnum::DEFAULT_LANG];
        //$this->isDatabaseConnected();
        if ($this->confirm('Is this API based application?', true)) {
            
            if ($this->confirm('Is camel case allowed for request and response', true)) {
                $this->selectedCase = ReusableLibEnum::CAMEL_CASE;
            }

            $result = $this->choice( 'Please choose API auth options?', ReusableLibEnum::API_AUTHS, ReusableLibEnum::DEFAULT_ZERO );
            
            $this->selectedApiAuth = $result;

            if ($result !== ReusableLibEnum::API_AUTH_NONE) {
                $this->isDatabaseConnected();
            }

            $this->artisanCommands[] = ReusableLibEnum::BOILERPLATE_COMMAND . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase;
            $this->chosenRoutes[] = RLRouteEnum::ROUTE_BOILERPLATE;

            if ($result == ReusableLibEnum::API_AUTH_PASSPORT) {
                $this->lastCommands[] = ReusableLibEnum::ARTISAN_PASSPORT_COMMAND;
            }

            $result = $this->choice( 'Please choose localization language and type default language at first(Example: 1 or 1, 0, 2).', $langArr, ReusableLibEnum::DEFAULT_ZERO, null, true );
            if ($result !== ReusableLibEnum::LANG_NA) {
                $this->selectedLangs = $result; 
            }
            
            if ($this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE && $this->confirm('Are Role and Permission needed in this application?', true)) {
                $this->artisanCommands[] = ReusableLibEnum::AUTHORIZATION_ARTISAN_COMMAND[ReusableLibEnum::DEFAULT_ROLE_AND_PERMISSION] . ' --case=' . $this->selectedCase;
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE;
            }

            if ($this->confirm('Is blog needed in this application?', true)) { 
                $this->artisanCommands[] = ReusableLibEnum::ARTISAN_COMMAND_BLOG . ' --auth=' . $this->selectedApiAuth . ' --case=' . $this->selectedCase;
                $this->chosenRoutes[] = RLRouteEnum::ROUTE_BLOG;
            }

        } else {
            $this->info('Sorry! There is no support at the moment!');
            return false;
        }
 
        $this->appendRoute();
        $this->appendEnv();
        $this->runExecCommands();  
        $this->runArtisanCommands(); 
        $this->updateConfig();
        $this->runLastArtisanCommands();
        $this->installLanguages();
        //$this->updateFileContent();
        
        $this->info('Reusable Library is installed successfully.');
    }

    protected function runExecCommands($paramCommands = [])
    {
        if (function_exists('exec')) { 
            $execCommands = !empty($paramCommands) ? $paramCommands : $this->execCommands; 
            foreach ($execCommands as $execCommand) {
                exec('cd ' . base_path() . ' && ' . $execCommand); 
            }
            exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
            $this->info('The Commands are run successfully.');
        } else {
            $this->error($this->prepareErrorMessage());
        } 
    }

    protected function prepareErrorMessage()
    {
        $rtrText =  "Please run below commands \n";
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
            $this->info('This ' . $artisanCommand . ' installed successfully!');
        } 
    }

    protected function appendRoute()
    {
        $routeStr = RLRouteEnum::ROUTE_API['basic']['group_start'];
        foreach ($this->chosenRoutes as $chosenRoute) {
            if ($chosenRoute == RLRouteEnum::ROUTE_BOILERPLATE) {
                foreach(RLRouteEnum::ROUTE_API[RLRouteEnum::ROUTE_BOILERPLATE]['without_auth'] as $bwAuthRow) {
                    $routeStr .=  $bwAuthRow;
                }

                if ( $this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE ) {
                    if (in_array(RLRouteEnum::ROUTE_CUSTOM_PERMISSION_ROLE, $this->chosenRoutes)) {
                        $routeStr .=  RLRouteEnum::ROUTE_API['basic']['auth_start'];
                    } else {
                        $routeStr .=  RLRouteEnum::ROUTE_API['basic']['auth_start_without_auth_gate'];
                    }
                }

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
        }
        
        if ( $this->selectedApiAuth !== ReusableLibEnum::API_AUTH_NONE ) {
            $routeStr .= RLRouteEnum::ROUTE_API['basic']['auth_end'];
        }
        
        $routeStr .= RLRouteEnum::ROUTE_API['basic']['group_end'];
         
        file_put_contents(base_path('routes/api.php'), $routeStr.PHP_EOL, FILE_APPEND | LOCK_EX); 
        $this->info('This route is appended successfully!');
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
            $this->info("This l5-swagger.php file is updated successfully!\n");
        }
    }

    protected function appendEnv()
    {
        if( ! file_exists(base_path('.env'))) {
            $this->error('.env file is not exists'); 
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
                $this->info('This resources/lang/' . $selectedShortLang .  ' files is installed successfully!');
            }
        }
         
    }
 

    // protected function updateFileContent()
    // { 
    //     //--- UPDATE app/Models/User.php 
    //     if (in_array(ReusableLibEnum::API_AUTH_PASSPORT, $this->selectedOptions)) {
    //         if (file_exists(app_path('Models/User.php'))) {
    //             $authFile = str_replace(
    //                 ['use Laravel\Sanctum\HasApiTokens;'], 
    //                 ['use Laravel\Passport\HasApiTokens;'],
    //                 file_get_contents(app_path('Models/User.php'))
    //             ); 
    //             file_put_contents(app_path('Models/User.php'), $authFile);
    //             $this->info('This app/Models/User.php file is updated successfully!');
    //         }
    //     }
    // }

}