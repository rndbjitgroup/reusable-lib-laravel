<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Utils\CmnUtil;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem; 

class NotificationInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:notification-install {--auth= : Auth type } {--case= : letter case } { --notification_types= : notification types } {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all stubs of Notification that are available';
    protected $execCommands = [];
    protected $notificationTypes = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->option('notification_types'), json_decode(base64_decode($this->option('notification_types'))));
        $this->setNotificationTypes();
        $this->handleInstallation();
        $this->info('Notification all files is installed successfully.');
    }

    protected function setNotificationTypes()
    {
        $this->notificationTypes = json_decode(base64_decode($this->option('notification_types')));
    }

    protected function handleInstallation()
    {
        $this->runExecCommands();
        $this->installFiles(); 
        //$this->updateFileContent(); 
    } 

    protected function runExecCommands()
    {
        $this->setExecCommands();
        if (function_exists('exec')) { 
            foreach($this->execCommands as $execCommand) {
                exec('cd ' . base_path() . ' && ' . $execCommand); 
                $this->info('Notification - ' . $execCommand . ' is run successfully.');
            }
            exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
            $this->info('The Notifications Commands are run successfully.');
        } else {
            $this->error($this->prepareErrorMessage());
        } 
    }

    protected function setExecCommands()
    {
        if (in_array(ReusableLibEnum::NOTIFICATION_PUSH, $this->notificationTypes)) {
            //$this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_PSR7;
            //$this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_PUSHER;
            //$this->execCommands[] = ReusableLibEnum::COMPOSER_AUTOLOAD;
            //$this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_WEBSOCKET;
            $this->execCommands[] = ReusableLibEnum::ARTISAN_BROADCASTING_REVERB;
        }

        if (in_array(ReusableLibEnum::NOTIFICATION_DATABASE, $this->notificationTypes)) {
            $this->execCommands[] = ReusableLibEnum::ARTISAN_COMMAND_NOTIFICATION_DATABSE; 
        }
    }

    protected function prepareErrorMessage()
    {
        $rtrText =  "Please run below commands \n";
        if(empty($this->execCommands)) {
            return false;
        }

        foreach($this->execCommands as $execCommand) {
            $rtrText .= $execCommand . " \n";
        }
        return $rtrText;
    }

    protected function installFiles()
    {
        $files = $this->notificationsFiles();  
 
        foreach ($files as $from => $to) { 
            if ( ! is_dir($stubsPath = $to['path'])) {  
                (new Filesystem)->makeDirectory($stubsPath, 0777, true);
            }  
             
            if ( ! file_exists($to['file'])  
                || str_contains($to['file'], ReusableLibEnum::MODEL_USER)
                || str_contains($to['file'], ReusableLibEnum::CONFIG_APP)
                || str_contains($to['file'], ReusableLibEnum::CONFIG_BROADCASTING)
                || $this->option('force')) {
                     
                    if ($this->option('auth') === ReusableLibEnum::API_AUTH_NONE) {
                        if (strpos($to['file'], 'Controller') !== false 
                            || strpos($to['file'], 'Request') !== false) {

                            $from = str_replace(
                                [
                                    'security={{"bearerAuth": {}}},',
                                    'Gate::authorize(\'notification-list\');',
                                    'Gate::authorize(\'notification-view\');',
                                    'Gate::authorize(\'notification-delete\');',
                                    'Gate::allows(\'notification-create\')',
                                    'Gate::allows(\'notification-edit\')', 
                                ], 
                                [
                                    '', '', '', '', 'true', 'true', 
                                ],
                                file_get_contents($from)
                            ); 
                        } else {
                            $from = file_get_contents($from);
                        } 
                    } else {
                        $from = file_get_contents($from);
                    }

                    //file_put_contents($to['file'], file_get_contents($from));
                    file_put_contents($to['file'], $from);
                    $mainFile = str_replace(base_path() . '/', '', $to['file']);
                    $this->info("This file {$mainFile} is installed successfully!");
            }
        }
    }

    protected function notificationsFiles()
    {
        $files = $this->arrangeFiles('Services');  
        //$files = array_merge($files, $this->configFile());   
        $files = array_merge($files, $this->arrangeFiles('Events'));  
        $files = array_merge($files, $this->arrangeFiles('Notifications'));  
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API'));
        //$files = array_merge($files, $this->arrangeFiles('RootFiles')); // DON'T REMOVE THIS LINE 

        return $files;
    }

    public function arrangeFiles($path, $module = 'Notifications', $isModuleEnabled = true)
    {
        $rtrArr = [];
        $stubPath = __DIR__ . '/../stubs/NotificationSystem/' . $module . '/' . $path;
        $files = (new Filesystem)->files($stubPath);
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
            
            foreach ($files as $file) {  
                $fileName = str_replace(['.stub', '.camelCase'], ['.php', ''], $file->getFilename());
                $installedAppPath = $path;
                if(!str_contains($path, ReusableLibEnum::APP_NOTIFICATIONS_FOLDER) 
                    && !str_contains($path, ReusableLibEnum::APP_EVENTS_FOLDER)) {
                    $installedAppPath = $path . '/' . $module;
                }

                if (! file_exists(app_path( $path . '/' . $file->getFilename())) 
                    //|| str_contains($fileName, ReusableLibEnum::MODEL_USER)
                    || $this->option('force')) {

                    $fileNameWithoutDot = explode('.', $file->getFilename())[0]; 
                    if ( CmnUtil::duplicateFileWithPattern($stubPath . '/*' . $fileNameWithoutDot. '*')) {
                        if ($this->option('case') === ReusableLibEnum::CAMEL_CASE 
                            && strpos($file->getFilename(), $this->option('case')) === false) {
                            continue;
                        }
                        if ($this->option('case') !== ReusableLibEnum::CAMEL_CASE 
                            && strpos($file->getFilename(), ReusableLibEnum::CAMEL_CASE) !== false) {
                            continue;
                        }
                    }    
                        
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => app_path( $installedAppPath ),
                        'file' => app_path( $installedAppPath ) . '/' . $fileName
                    ];
                }

                if(str_contains($path, ReusableLibEnum::ROOT_FILES)) { 

                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path( '/' ),
                        'file' => base_path( '/')  . $fileName
                    ];
                }
            } 
        } 
        return $rtrArr;
    }
    

    // protected function databaseFiles()
    // {
    //     $files = $this->migrationFiles();
    //     return $files;
    // }

    // protected function migrationFiles()
    // {
    //     $rtrArr = [];
    //     $files = (new Filesystem)->files(__DIR__ . '/../stubs/NotificationSystem/database/migrations');
         
    //     if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
    //         foreach ($files as $file) {  
    //             $mTime = time();
    //             if(str_contains($file->getFilename(), 'comments')) {
    //                 $mTime += 1;
    //             }
    //             $fileName = str_replace('.stub', '.php', $file->getFilename());
    //             if ($this->option('force') || ! CmnUtil::fileExistsWithPattern(base_path('database/migrations/' . '*' . $fileName))) {
    //                 $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
    //                     'path' => base_path('database/migrations'),
    //                     'file' => base_path('database/migrations') . '/' . date('Y_m_d_His', $mTime) . '_' . $fileName
    //                 ];
    //             }
    //         } 
    //     }
    //     return $rtrArr;
    // }
 

    protected function updateFileContent()
    {
        //--- UPDATE config/app.php ---
        if (file_exists(config_path('app.php'))) {
            $configFile = str_replace(
                [
                    '// App\Providers\BroadcastServiceProvider::class', 
                ], 
                [
                    'App\Providers\BroadcastServiceProvider::class', 
                ],
                file_get_contents(config_path('app.php'))
            ); 
            file_put_contents(config_path('app.php'), $configFile);
            $this->info('This config/app.php file is updated successfully!');
        }

        if (file_exists(config_path('broadcasting.php'))) {
            
        }
    } 


    // protected function configFile()
    // {
    //     return [
    //         __DIR__.'/../stubs/NotificationSystem/config/broadcasting.stub' => [
    //             'path' => base_path('config'), 'file' => base_path('config').'/broadcasting.php'
    //         ]
    //     ];
    // }

}