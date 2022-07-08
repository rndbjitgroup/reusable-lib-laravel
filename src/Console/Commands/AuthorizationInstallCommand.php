<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Utils\CmnUtil;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem; 

class AuthorizationInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:authorization-install {--case= : letter case } {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all stubs of Authorization that are available';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleInstallation();
        $this->info('Authorization all files is installed successfully.');
    }

    protected function handleInstallation()
    {
        $this->installFiles();  
        $this->updateFileContent();
    } 

    protected function installFiles()
    {
        $files = $this->arrangeFiles('Traits', 'PermissionsAndRoles'); 
        $files = array_merge($files, $this->arrangeFiles('Models', 'PermissionsAndRoles'));
        $files = array_merge($files, $this->arrangeFiles('Repositories', 'PermissionsAndRoles'));
        $files = array_merge($files, $this->arrangeFiles('Services', 'PermissionsAndRoles'));
        $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'PermissionsAndRoles'));
        $files = array_merge($files, $this->arrangeFiles('Http/Middleware', 'PermissionsAndRoles', false));
        $files = array_merge($files, $this->arrangeFiles('Http/Requests', 'PermissionsAndRoles'));
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/Api', 'PermissionsAndRoles'));
        
        $files = array_merge($files, $this->arrangeFiles('Repositories', 'Users'));
        $files = array_merge($files, $this->arrangeFiles('Services', 'Users'));
        $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'Users')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Requests', 'Users'));
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/Api', 'Users'));
        
        $files = array_merge($files, $this->databaseFiles());
        //$files = array_merge($files, $this->overideFileFiles());
        //dd($files); 
        
        foreach ($files as $from => $to) { 
            if (! is_dir($stubsPath = $to['path'])) {  
                (new Filesystem)->makeDirectory($stubsPath, 0777, true);
            }  
            if (! file_exists($to['file'])  
                //|| strpos($to['file'], ReusableLibEnum::MODEL_USER) !== false
                || strpos($to['file'], ReusableLibEnum::SEEDER_MAIN_FILE) !== false
                || $this->option('force')) {
                file_put_contents($to['file'], file_get_contents($from));
                $mainFile = str_replace(base_path() . '/', '', $to['file']);
                $this->info("This file {$mainFile} is installed successfully!");
            }
        }
    }

    public function arrangeFiles($path, $module, $isModuleEnabled = true)
    {
        $rtrArr = [];
        $stubPath = __DIR__ . '/../stubs/Authorization/' . $module . '/' . $path;
        $files = (new Filesystem)->files($stubPath);
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            $installedAppPath = $path;
            if($isModuleEnabled) {
                $installedAppPath = $path . '/' . $module;
            }
            foreach ($files as $file) {  
                if (! file_exists(app_path( $path . '/' . $file->getFilename())) || $this->option('force')) {
                    
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
                        'file' => app_path( $installedAppPath ) . '/' . str_replace(['.stub', '.camelCase'], ['.php', ''], $file->getFilename())
                    ];
                }
            } 
        }
        return $rtrArr;
    }
    

    protected function databaseFiles()
    {
        $files = $this->migrationFiles();
        $files = array_merge($files, $this->seederFiles()); 
        return $files;
    }

    protected function migrationFiles()
    {
        $rtrArr = [];
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/Authorization/database/migrations');
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            foreach ($files as $file) { 
                $fileName = str_replace('.stub', '.php', $file->getFilename());
                $mTime = time();
                if(str_contains($file->getFilename(), 'role_user') 
                    || str_contains($file->getFilename(), 'permission_role')) {
                    $mTime += 1;
                }
                if (! CmnUtil::fileExistsWithPattern(base_path('database/migrations/' . '*' . $fileName)) || $this->option('force')) {
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path('database/migrations'),
                        'file' => base_path('database/migrations') . '/' . date('Y_m_d_His', $mTime) . '_' . $fileName
                    ];
                }
            } 
        }
        return $rtrArr;
    }

    protected function seederFiles()
    {
        $rtrArr = [];
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/Authorization/database/seeders');
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
            foreach ($files as $file) { 
                $seederFileName = str_replace('.stub', '.php', $file->getFilename()); 
                if (($seederFileName == ReusableLibEnum::SEEDER_MAIN_FILE)
                    || ! file_exists(base_path( 'database/seeders' . '/' . $file->getFilename()))
                    || $this->option('force')) {
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path('database/seeders'),
                        'file' => base_path('database/seeders') . '/' . $seederFileName
                    ];
                }
            } 
        } 
        return $rtrArr;
    } 

    // protected function overideFileFiles()
    // {
    //     return [ 
    //         __DIR__.'/../stubs/Authorization/Users/Models/User.stub' => [
    //             'path' => app_path('Models'), 'file' => app_path('Models').'/User.php'
    //         ], 
    //     ];
    // }

    protected function updateFileContent()
    {
        //--- UPDATE app/Models/User.php ---
        if (file_exists(app_path('Models/User.php'))) {
            $userModelFile = str_replace(
                [
                    '//use App\Traits\PermissionsAndRoles\CustomPermission;',
                    '//use CustomPermission;'
                ], 
                [
                    'use App\Traits\PermissionsAndRoles\CustomPermission;',
                    'use CustomPermission;'
                ],
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $userModelFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

    }
    

}