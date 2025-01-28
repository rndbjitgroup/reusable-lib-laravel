<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Utils\CmnUtil;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem; 

class BoilerplateInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:boilerplate-install {--auth= : Auth type } {--case= : letter case } {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all stubs of boilerplate that are available';
    protected $execCommands = [];
    protected $artisanCommands = [];
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleInstallation();
        $this->info('Boilerplate all files installed successfully.');
    }

    protected function handleInstallation()
    {
        $this->runExecCommands();
        $this->installFiles(); 
        $this->configureForAuth();
        $this->updateEnum();
        $this->updateBootstrapApp();
        //$this->runArtisanCommands(); 
    } 

    protected function runExecCommands($paramCommands = [])
    {
        $this->setExecCommands();
        if (function_exists('exec')) { 
            $execCommands = !empty($paramCommands) ? $paramCommands : $this->execCommands; 

            $this->withProgressBar($execCommands, function ($execCommand) {
                exec('cd ' . base_path() . ' && ' . $execCommand);
                $this->info('Boilerplate - ' . $execCommand . ' is run successfully.');
            });
            exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
            $this->info('The Boilerplate Commands are run successfully.');
        } else {
            $this->error($this->prepareErrorMessage());
        } 
    }

    protected function setExecCommands()
    {
        if (isset(ReusableLibEnum::API_AUTH_COMMAND[$this->option('auth')])) {
            $this->execCommands[] = ReusableLibEnum::API_AUTH_COMMAND[$this->option('auth')];
        }
        
        if ($this->option('auth') == ReusableLibEnum::API_AUTH_JWT) {
            $this->execCommands[] = ReusableLibEnum::API_AUTH_JWT_VENDOR_PUBLISH;
            $this->execCommands[] = ReusableLibEnum::API_AUTH_JWT_SECRET;
        }

        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_IMAGE_RESIZE;
        $this->execCommands[] = ReusableLibEnum::OPEN_API_COMPOSER_COMMAND;
        $this->execCommands[] = ReusableLibEnum::OPEN_API_ARTISAN_PUBLISH_COMMMAND; 

        //dd($this->execCommands);
    } 

    protected function prepareErrorMessage()
    {
        $rtrText =  __('messages.runCommandText') . "\n";
        if(empty($this->execCommands)) {
            return false;
        }

        foreach($this->execCommands as $execCommand) {
            $rtrText .= $execCommand . " \n";
        }
        return $rtrText;
    }

    protected function configureForAuth()
    {
        if ($this->option('auth') == ReusableLibEnum::API_AUTH_PASSPORT) {
            $this->configureForPassport();
        }

        if ($this->option('auth') == ReusableLibEnum::API_AUTH_JWT) {
            $this->configureForJWT();
        }
    }

    protected function configureForPassport()
    {
        if (file_exists(app_path('Models/User.php'))) {
            $authFile = str_replace(
                ['use Laravel\Sanctum\HasApiTokens;'], 
                ['use Laravel\Passport\HasApiTokens;'],
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $authFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

        // --- UPDATE AUTH CONFIG FILE --- 
        $autFile = file_get_contents(__DIR__.'/../stubs/Boilerplate/config/auth.stub');
        if((int) app()->version() > ReusableLibEnum::LARAVEL_VERSION_NINE) {
            $autFile = str_replace(
                ['password_resets'], 
                ['password_reset_tokens'],
                file_get_contents(__DIR__.'/../stubs/Boilerplate/config/auth.stub')
            ); 
        }
        file_put_contents(config_path('auth.php'), $autFile);
        $this->info('This config/auth.php file is updated successfully!');
        

        // --- UPDATE AUTH SERVICE PROVIDER ---
        // if(strpos(app()->version(), ReusableLibEnum::LARAVEL_VERSION_EIGHT) !== ReusableLibEnum::DEFAULT_FALSE ) {
        //     file_put_contents(app_path('Providers/AuthServiceProvider.php'), file_get_contents(__DIR__.'/../stubs/Boilerplate/Auth/Providers/AuthServiceProvider.stub'));
        //     $this->info('This Providers/AuthServiceProvider.php file is updated successfully!');
        // } // No need to update for Laravel 8 and after 11 version

        // --- UPDATE ROUTE --- 
        if (file_exists(base_path('routes/api.php'))) {
            $routeFile = str_replace(
                ['auth:sanctum'],
                ['auth:api'],
                file_get_contents(base_path('routes/api.php'))
            );
            file_put_contents(base_path('routes/api.php'), $routeFile);
            $this->info('This routes/api.php file is updated successfully!');
        }

        // --- REGISTER SERVICE ---
        if (file_exists(app_path('Services/Auth/RegisterService.php'))) {
            $regServiceFile = str_replace(
                ['plainTextToken'], 
                ['accessToken'],
                file_get_contents(app_path('Services/Auth/RegisterService.php'))
            );
            file_put_contents(app_path('Services/Auth/RegisterService.php'), $regServiceFile);
            $this->info('This app/Services/Auth/RegisterService.php service file is updated successfully!');
        }

        // --- LOGIN SERVICE ---
        if (file_exists(app_path('Services/Auth/LoginService.php'))) {
            $regServiceFile = str_replace(
                ['plainTextToken'], 
                ['accessToken'],
                file_get_contents(app_path('Services/Auth/LoginService.php'))
            );
            file_put_contents(app_path('Services/Auth/LoginService.php'), $regServiceFile);
            $this->info('This app/Services/Auth/LoginService.php service file is updated successfully!');
        }
    }

    protected function configureForJWT()
    {
        if (file_exists(app_path('Models/User.php'))) {
            $userModelFile = str_replace(
                [
                    '//use Tymon\JWTAuth\Contracts\JWTSubject;',
                    'extends Authenticatable',
                    '//use App\Traits\Common\CustomJwtToken;',
                    '//use CustomJwtToken;'
                ], 
                [
                    'use Tymon\JWTAuth\Contracts\JWTSubject;',
                    'extends Authenticatable implements JWTSubject',
                    'use App\Traits\Common\CustomJwtToken;',
                    'use CustomJwtToken;'
                ],
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $userModelFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

        // --- UPDATE AUTH CONFIG FILE --- 
        $autFile = str_replace(
            ['passport'], 
            ['jwt'],
            file_get_contents(__DIR__.'/../stubs/Boilerplate/config/auth.stub')
        ); 
        if((int) app()->version() > ReusableLibEnum::LARAVEL_VERSION_NINE) {
            $autFile = str_replace(
                ['password_resets'], 
                ['password_reset_tokens'],
                $autFile
            ); 
        }
        file_put_contents(config_path('auth.php'), $autFile);
        $this->info('This config/auth.php file is updated successfully!');
        
        // --- UPDATE ROUTE --- 
        if (file_exists(base_path('routes/api.php'))) {
            $routeFile = str_replace(
                ['auth:sanctum'],
                ['auth:api'],
                file_get_contents(base_path('routes/api.php'))
            );
            file_put_contents(base_path('routes/api.php'), $routeFile);
            $this->info('This routes/api.php file is updated successfully!');
        }

        // --- REGISTER SERVICE ---
        if (file_exists(app_path('Services/Auth/RegisterService.php'))) {
            $regServiceFile = str_replace(
                [
                    '\'token\' => $user->createToken($user->email)->plainTextToken,',
                    '//\'token\' => auth(\'api\')->login($user),'
                ], 
                ['', '\'token\' => auth(\'api\')->login($user),'],
                file_get_contents(app_path('Services/Auth/RegisterService.php'))
            );
            file_put_contents(app_path('Services/Auth/RegisterService.php'), $regServiceFile);
            $this->info('This app/Services/Auth/RegisterService.php service file is updated successfully!');
        }

        // --- LOGIN SERVICE ---
        if (file_exists(app_path('Services/Auth/LoginService.php'))) {
            $regServiceFile = str_replace(
                [
                    '\'token\' => $user->createToken($user->email)->plainTextToken,',
                    '//\'token\' => auth(\'api\')->login($user),',
                    '//auth()->logout();'
                ], 
                ['', '\'token\' => auth(\'api\')->login($user),', 'auth()->logout();'],
                file_get_contents(app_path('Services/Auth/LoginService.php'))
            );
            file_put_contents(app_path('Services/Auth/LoginService.php'), $regServiceFile);
            $this->info('This app/Services/Auth/LoginService.php service file is updated successfully!');
        }

    }

    protected function installFiles()
    {
        $files =  $this->commonFiles();
        //$files = array_merge($files, $this->configFile());

        $files = array_merge($files, $this->arrangeExceptionFiles('Exceptions', 'Custom'));
        
        if ($this->option('auth') !== ReusableLibEnum::API_AUTH_NONE) {
            //$files = array_merge($files, $this->arrangeFiles('Models', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Interfaces', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Repositories', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Services', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Http/Requests', 'Auth'));
            $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API', 'Auth'));
        
            $files = array_merge($files, $this->arrangeFiles('Rules', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Interfaces', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Repositories', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Services', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Http/Requests', 'Profile'));
            $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API', 'Profile'));
        }

        $files = array_merge($files, $this->arrangeFiles('Models', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Interfaces', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Repositories', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Services', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Http/Requests', 'Samples'));
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API', 'Samples'));
        
        //if ($this->option('auth') !== ReusableLibEnum::API_AUTH_NONE) {
            $files = array_merge($files, $this->migrationFiles());
        //}
 
        foreach ($files as $from => $to) { 
            if (! is_dir($stubsPath = $to['path'])) {  
                (new Filesystem)->makeDirectory($stubsPath, 0777, true);
            }  
            if (! file_exists($to['file']) 
                || strpos($to['file'], ReusableLibEnum::MODEL_USER) !== false
                //|| strpos($to['file'], ReusableLibEnum::HTTP_KERNEL) !== false
                || str_contains($to['file'], ReusableLibEnum::CONFIG_APP)
                || strpos($to['file'], ReusableLibEnum::EXCEPTION_HANDLER) !== false
                || $this->option('force')) {
                    
                    if ($this->option('auth') === ReusableLibEnum::API_AUTH_NONE 
                        && strpos($to['file'], 'Controller') !== false) {
        
                        $from = str_replace(
                            ['security={{"bearerAuth": {}}},'], 
                            [''],
                            file_get_contents($from)
                        );    
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

    public function arrangeFiles($path, $module = null)
    {
        $rtrArr = [];
        $stubPath = __DIR__ . '/../stubs/Boilerplate/' . $module . '/' . $path;
        $files = (new Filesystem)->files($stubPath);
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            foreach ($files as $file) {  
                $fileName = str_replace(['.stub', '.camelCase'], ['.php', ''], $file->getFilename());
                $installedAppPath = $path;
                
                if ( ! str_contains($fileName, ReusableLibEnum::MODEL_USER)
                    && ! str_contains($fileName, ReusableLibEnum::MODEL_BASE_MODEL)) {
                    $installedAppPath = $path . '/' . $module;
                }

                if ( ! file_exists(app_path( $path . '/' . $file->getFilename())) || $this->option('force')) {
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
            } 
        }
        return $rtrArr;
    }

    public function arrangeExceptionFiles($path, $module, $isRoot = false)
    {
        $rtrArr = [];
        $prefix = 'app';
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/Common/Exceptions/' . $module);
        if ($isRoot) {
            $prefix = '';
        }
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            foreach ($files as $file) {  
                if ( ! file_exists(app_path( $path . '/' . $file->getFilename())) || $this->option('force')) {
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path( $prefix . '/' . $path . '/' . $module),
                        'file' => base_path( $prefix . '/' . $path . '/' . $module) . '/' . str_replace('.stub', '.php', $file->getFilename())
                    ];
                }
            } 
        }
        return $rtrArr;
    }

    protected function commonFiles()
    {
        $case = '';
        if ($this->option('case') === ReusableLibEnum::CAMEL_CASE) {
            $case = '.' . $this->option('case');
        }

        $rtrArr = [
            __DIR__.'/../stubs/Common/config/constants.stub' => [
                'path' => base_path('config'), 'file' => base_path('config').'/constants.php'
            ],
            __DIR__.'/../stubs/Common/Enums/CmnEnum.stub' => [
                'path' => app_path('Enums'), 'file' => app_path('Enums').'/CmnEnum.php'
            ],
            __DIR__.'/../stubs/Common/Models/User' . $case . '.stub' => [
                'path' => app_path('Models'), 'file' => app_path('Models').'/User.php'
            ],
            __DIR__.'/../stubs/Common/Traits/RespondsWithHttpStatus' . $case . '.stub' => [
                'path' => app_path('Traits/Common'), 'file' => app_path('Traits/Common').'/RespondsWithHttpStatus.php'
            ],
            __DIR__.'/../stubs/Common/Traits/CustomException.stub' => [
                'path' => app_path('Traits/Common'), 'file' => app_path('Traits/Common').'/CustomException.php'
            ],
            __DIR__.'/../stubs/Common/Notifications/ResetPasswordNotification.stub' => [
                'path' => app_path('Notifications'), 'file' => app_path('Notifications').'/ResetPasswordNotification.php'
            ],
            __DIR__.'/../stubs/Common/Exceptions/Handler.stub' => [
                'path' => app_path('Exceptions'), 'file' => app_path('Exceptions').'/Handler.php'
            ],
            __DIR__.'/../stubs/Common/Http/Controllers/BaseController.stub' => [
                'path' => app_path('Http/Controllers/API'), 'file' => app_path('Http/Controllers/API').'/BaseController.php'
            ],
            __DIR__.'/../stubs/Common/Http/Middleware/Localization.stub' => [
                'path' => app_path('Http/Middleware'), 'file' => app_path('Http/Middleware').'/Localization.php'
            ],
            // __DIR__.'/../stubs/Common/Http/Kernel.stub' => [
            //     'path' => app_path('Http'), 'file' => app_path('Http').'/Kernel.php'
            // ],
            __DIR__.'/../stubs/Common/Http/Resources/PaginationResource' . $case . '.stub' => [
                'path' => app_path('Http/Resources/Common'), 'file' => app_path('Http/Resources/Common').'/PaginationResource.php'
            ],
            __DIR__.'/../stubs/Common/Http/Resources/CommonArrayResource' . $case . '.stub' => [
                'path' => app_path('Http/Resources/Common'), 'file' => app_path('Http/Resources/Common').'/CommonArrayResource.php'
            ],
            __DIR__.'/../stubs/Common/resources/views/vendor/notifications/email.blade.stub' => [
                'path' => base_path('resources/views/vendor/notifications'), 'file' => base_path('resources/views/vendor/notifications').'/email.blade.php'
            ],
        ];

        if ($this->option('case') === ReusableLibEnum::CAMEL_CASE) {
            $rtrArr = array_merge(
                $rtrArr,
                [
                    __DIR__.'/../stubs/Common/Models/BaseModel.stub' => [
                        'path' => app_path('Models'), 'file' => app_path('Models').'/BaseModel.php'
                    ],
                    __DIR__.'/../stubs/Common/Traits/AllowCamelCase.stub' => [
                        'path' => app_path('Traits/Common'), 'file' => app_path('Traits/Common').'/AllowCamelCase.php'
                    ],
                ]
            );
        }

        if ($this->option('auth') === ReusableLibEnum::API_AUTH_JWT) {
            $rtrArr = array_merge(
                $rtrArr,
                [
                    __DIR__.'/../stubs/Common/Traits/CustomJwtToken.stub' => [
                        'path' => app_path('Traits/Common'), 'file' => app_path('Traits/Common').'/CustomJwtToken.php'
                    ] 
                ]
            );
        }
        return $rtrArr;
    }

    // protected function configFile()
    // {
    //     return [
    //         __DIR__.'/../stubs/Boilerplate/config/app.stub' => [
    //             'path' => base_path('config'), 'file' => base_path('config').'/app.php'
    //         ]
    //     ];
    // }

    protected function migrationFiles()
    {
        $rtrArr = [];
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/Boilerplate/database/migrations');
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            foreach ($files as $file) { 
                $fileName = str_replace('.stub', '.php', $file->getFilename());
               
                if ($this->option('force') || ! CmnUtil::fileExistsWithPattern(base_path('database/migrations/' . '*' . $fileName))) {
                    
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path('database/migrations'),
                        'file' => base_path('database/migrations') . '/' . date('Y_m_d_His', time()) . '_' . $fileName
                    ];
                } 
            } 
        } 
        return $rtrArr;
    }
 
    protected function updateEnum()
    {
        $cmnEnum = str_replace(
            ["API_SELECTED_AUTH = 'Sanctum';"], 
            ["API_SELECTED_AUTH = '" . $this->option('auth') . "';"], 
            file_get_contents(app_path('Enums/CmnEnum.php'))
        ); 
        file_put_contents(app_path('Enums/CmnEnum.php'), $cmnEnum); 
        $this->info('This app/Enums/CmnEnum.php file is updated successfully!');

        // $rlEnum = preg_replace(
        //     ["/API_SELECTED_AUTH = '[A-Za-z]+';/i"], 
        //     ["API_SELECTED_AUTH = '" . $this->option('auth') . "';"], 
        //     file_get_contents(__DIR__. '/../../Enums/ReusableLibEnum.php' )
        // ); 
        // file_put_contents(__DIR__. '/../../Enums/ReusableLibEnum.php', $rlEnum);  
    }

    protected function updateBootstrapApp()
    {
        $bootstrapApp = str_replace(
            [
                '$middleware->api(prepend: [',
                "->create();"
            ], 
            [
                '$middleware->api(prepend: [' . "\n" . '            \App\Http\Middleware\Localization::class,',
                "->withSingletons([\n       \Illuminate\Contracts\Debug\ExceptionHandler::class => \App\Exceptions\Handler::class,\n    ])->create();"
            ], 
            file_get_contents(base_path('bootstrap/app.php'))
        ); 
        file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp); 
        $this->info('This bootstrap/app.php file is updated successfully!');
    }

}