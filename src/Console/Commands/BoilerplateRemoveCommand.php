<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum; 
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BoilerplateRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:boilerplate-remove {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files of boilerplate that are available';
    protected $execCommands = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('force') || $this->confirm('Do you really want to remove?', false)) {
            $this->handleRemove();
            $this->info('Boilerplate is removed successfully.');
        } else {
            $this->info('There is no change in Boilerplate.');
        }  
    }

    protected function handleRemove()
    {
        $this->runRemoveExecCommands();
        $this->updateFilesForAuth();
        $this->removeDirectory();
        $this->removeFileContent(); 
        $this->deleteExtraDirecotriesOrFiles();
        $this->deleteMigrationFiles();
        $this->removeOtherDirectory();
    }

    protected function runRemoveExecCommands()
    {
        $this->setExecCommands();
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

    protected function setExecCommands()
    {
        $this->execCommands[] = ReusableLibEnum::OPEN_API_COMPOSER_REMOVE_COMMAND; 
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

    protected function updateFilesForAuth()
    {
        $this->updateFilesForCommon();
        $this->updateFilesForPassport();
        $this->updateFilesForJWT();
    }

    protected function updateFilesForCommon()
    {
        if (file_exists(app_path('Models/User.php'))) {
            //dd(file_get_contents(app_path('Models/User.php')));
            $useModelFile = str_replace(
                [
                    "use App\Traits\Common\AllowCamelCase;\n",
                    "use AllowCamelCase;\n", 
                    "'contactNo',\n",
                    "'profilePhotoPath'",
                    // 'public function sendPasswordResetNotification($token)
                    // {
                    //     $this->notify(new ResetPasswordNotification($token));
                    // }',
                    // 'use App\Notifications\ResetPasswordNotification;'
                ],
                ['', '', '', ''], 
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $useModelFile);
            $this->info('This app/Models/User.php file for common is updated successfully!');
        }
    }

    protected function updateFilesForPassport()
    {
        if (file_exists(app_path('Models/User.php'))) {
            $useModelFile = str_replace(
                'use Laravel\Passport\HasApiTokens;',
                'use Laravel\Sanctum\HasApiTokens;', 
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $useModelFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

        // --- UPDATE AUTH CONFIG FILE --- 
        file_put_contents(config_path('auth.php'), file_get_contents(__DIR__.'/../stubs/Boilerplate/config/auth.default.stub'));
        $this->info('This config/auth.php file is updated successfully!');
        

        // --- UPDATE AUTH SERVICE PROVIDER ---
        $providerFile = str_replace(
            [
                "Passport::routes();",
                "use Laravel\Passport\Passport;"
            ],
            ['', ''], 
            file_get_contents(app_path('Providers/AuthServiceProvider.php'))
        ); 
        file_put_contents(app_path('Providers/AuthServiceProvider.php'), $providerFile);
        $this->info('This provider app/Providers/AuthServiceProvider.php file is updated successfully!');
        
        // --- UPDATE ROUTE --- 
        if (file_exists(base_path('routes/api.php'))) {
            $routeFile = str_replace(
                'auth:api',
                'auth:sanctum', 
                file_get_contents(base_path('routes/api.php'))
            );
            file_put_contents(base_path('routes/api.php'), $routeFile);
            $this->info('This routes/api.php file is updated successfully!');
        }

    }

    protected function updateFilesForJWT()
    {
        if (file_exists(app_path('Models/User.php'))) {
            $useModelFile = str_replace(
                [
                    "extends Authenticatable implements JWTSubject",
                    "use Tymon\JWTAuth\Contracts\JWTSubject;\n",
                    "use App\Traits\Common\CustomJwtToken;\n",
                    "use CustomJwtToken;\n", 
                ],
                ['extends Authenticatable','', '', ''], 
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $useModelFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

        // --- UPDATE AUTH CONFIG FILE --- 
        file_put_contents(config_path('auth.php'), file_get_contents(__DIR__.'/../stubs/Boilerplate/config/auth.default.stub'));
        $this->info('This config/auth.php file is updated successfully!');
        
        // --- UPDATE ROUTE --- 
        if (file_exists(base_path('routes/api.php'))) {
            $routeFile = str_replace(
                'auth:api',
                'auth:sanctum', 
                file_get_contents(base_path('routes/api.php'))
            );
            file_put_contents(base_path('routes/api.php'), $routeFile);
            $this->info('This routes/api.php file is updated successfully!');
        }

    }

    protected function removeDirectory()
    {
        $directory =  $this->commonDirectory();
        $directory = array_merge($directory, $this->authDirectory());
        $directory = array_merge($directory, $this->sampleDirectory());
 
        foreach ($directory as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            }   
            (new Filesystem)->deleteDirectory($directoryPath);
            $mainPath = str_replace(base_path() . '/', '', $directoryPath);
            $this->info("This path {$mainPath} is removed successfully!");
        }
        
    }

    protected function removeOtherDirectory()
    {
        $otherDirectory = $this->otherDirectory();

        foreach ($otherDirectory as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            } 
            if (count((new Filesystem)->files($directoryPath)) == ReusableLibEnum::DEFAULT_ZERO) {
                (new Filesystem)->deleteDirectory($directoryPath);
                $mainPath = str_replace(base_path() . '/', '', $directoryPath);
                $this->info("This path {$mainPath} is removed successfully!");
            }
             
        }
    }

    protected function commonDirectory()
    {
        return [
            ['path' => app_path('Enums')],
            ['path' => app_path('Traits')],
            ['path' => app_path('Rules')],
            ['path' => app_path('Http/Controllers/Api')],
            ['path' => app_path('Exceptions/Custom')],
            ['path' => base_path('resources/views/vendor/l5-swagger')],
        ];
    }

    protected function authDirectory()
    {
        return [ 
            ['path' => app_path('Repositories/Auth')],
            ['path' => app_path('Services/Auth')],
            ['path' => app_path('Http/Resources/Auth')],
            ['path' => app_path('Http/Resources/Common')],
            ['path' => app_path('Http/Controllers/Api/Auth')],
            ['path' => app_path('Http/Requests/Auth')],
        ];
    }

    protected function sampleDirectory()
    {
        return [
            ['path' => app_path('Models/Samples')],
            ['path' => app_path('Repositories/Samples')],
            ['path' => app_path('Services/Samples')],
            ['path' => app_path('Http/Resources/Samples')],
            ['path' => app_path('Http/Controllers/Api/Samples')],
            ['path' => app_path('Http/Requests/Samples')],
        ];
    }

    protected function otherDirectory()  
    {
        return [
            ['path' => app_path('Notifications')],
            ['path' => app_path('Repositories')],
            ['path' => app_path('Services')],
            ['path' => app_path('Http/Resources')],
            ['path' => app_path('Http/Requests')],
            ['path' => base_path('resources/views/vendor/notifications')],
            ['path' => base_path('resources/views/vendor')],
        ];
    }

    protected function removeFileContent()
    {
        $files = $this->fileContentList();
        $mainFile = '';
        foreach ($files as $from => $to) {  
            if (file_exists($to['file']) || $this->option('force')) {
                $from = file_get_contents($to['file']);
                if (str_contains($to['file'], ReusableLibEnum::EXCEPTION_HANDLER)) {
                    $from = str_replace(
                        ['use CustomException;', 'CustomException,', ', CustomException'], 
                        ['', '', ''], 
                        $from
                    );
                    file_put_contents($to['file'], $from);
                    $mainFile = str_replace(base_path() . '/', '', $to['file']); 
                }

                if (str_contains($to['file'], ReusableLibEnum::CONFIG_APP)) {
                    $from = str_replace(
                        [
                            "Intervention\Image\ImageServiceProvider::class,", 
                            "'Image' => Intervention\Image\Facades\Image::class,"
                        ], 
                        ['', ''], 
                        $from
                    );
                    file_put_contents($to['file'], $from);
                    $mainFile = str_replace(base_path() . '/', '', $to['file']);
                }

                if (str_contains($to['file'], ReusableLibEnum::HTTP_KERNEL)) {
                    $from = str_replace(
                        [
                            "'localization',",
                            "'localization' => \App\Http\Middleware\Localization::class,"
                        ], 
                        ['', ''], 
                        $from
                    );
                    file_put_contents($to['file'], $from);
                    $mainFile = str_replace(base_path() . '/', '', $to['file']);
                }
                if($mainFile !== '') {
                    $this->info("This file {$mainFile} is updated successfully!");
                    $mainFile = '';
                }
            }
        }
    }

    protected function fileContentList()
    {
        return [
            ['file' => app_path('Http/Kernel.php')],
            ['file' => app_path('Exceptions/Handler.php')],
            ['file' => config_path('app.php')],
        ];
    }

    protected function deleteExtraDirecotriesOrFiles()
    {
        $files = $this->extraFilesForDelete();
        foreach ($files as $to) {
            if (! file_exists($filePath = $to['file'])) {  
                continue;
            } 
            (new Filesystem)->delete($filePath); 
            $mainFile = str_replace(base_path() . '/', '', $filePath);
            $this->info("This path {$mainFile} is removed successfully!");
        }
    }

    protected function extraFilesForDelete()
    {
        return [ 
            ['file' => app_path('Http/Middleware/Localization.php')],
            ['file' => app_path('Models/BaseModel.php')],
            ['file' => app_path('Notifications/ResetPasswordNotification.php')],
            ['file' => base_path('resources/views/vendor/notifications/email.blade.php')],
            //['file' => base_path('resources/lang/en/messages.php')],
            ['file' => base_path('config/l5-swagger.php')],
            ['file' => base_path('config/constants.php')],
            ['file' => base_path('config/jwt.php')],
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
                    $this->info("This file {$mainFile} is removed successfully!");
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
        return [
            'add_profile_photo_path_and_contact_no_to_users.php' => 'add_profile_photo_path_and_contact_no_to_users.php',
            'create_samples_table.php' => 'create_samples_table.php',
        ];
    } 

}