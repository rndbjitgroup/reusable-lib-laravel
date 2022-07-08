<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AuthorizationRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:authorization-remove {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files of Authorization that are available';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('force') || $this->confirm('Do you really want to remove?', false)) {
            $this->handleRemove();
            $this->info('Authorization is removed successfully.');
        } else {
            $this->info('There is no change in Authorization.');
        }  
    }

    protected function handleRemove()
    {
        $this->deleteMigrationFiles();
        $this->removeDirectory(); 
        $this->removeFileContent(); 
        $this->deleteExtraDirecotriesOrFiles();
    }

    protected function removeDirectory()
    {
        $directory =  $this->permissionsAndRolesDirectory();
        $directory = array_merge($directory, $this->userDirectory()); 
 
        foreach ($directory as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            }   
            (new Filesystem)->deleteDirectory($directoryPath);
            $mainPath = str_replace(base_path() . '/', '', $directoryPath);
            $this->info("This path {$mainPath} is removed successfully!");
        }
        
    } 

    protected function permissionsAndRolesDirectory()
    {
        return [ 
            ['path' => app_path('Models/PermissionsAndRoles')],
            ['path' => app_path('Repositories/PermissionsAndRoles')],
            ['path' => app_path('Services/PermissionsAndRoles')],
            ['path' => app_path('Http/Resources/PermissionsAndRoles')],
            ['path' => app_path('Http/Controllers/Api/PermissionsAndRoles')],
            ['path' => app_path('Http/Requests/PermissionsAndRoles')],
        ];
    }

    protected function userDirectory()
    {
        return [ 
            ['path' => app_path('Repositories/Users')],
            ['path' => app_path('Services/Users')],
            ['path' => app_path('Http/Resources/Users')],
            ['path' => app_path('Http/Controllers/Api/Users')],
            ['path' => app_path('Http/Requests/Users')],
        ];
    }

    protected function removeFileContent()
    {
        $files = $this->fileContentList();
        foreach ($files as $from => $to) {  
           
            if ((file_exists($to['file']) && strpos($to['file'], ReusableLibEnum::MODEL_USER) !== false)) {
                $from = file_get_contents($to['file']);
                $from = str_replace(
                    [
                        "//use App\Traits\PermissionsAndRoles\CustomPermission;\n",
                        "//use CustomPermission;\n",
                        "use App\Traits\PermissionsAndRoles\CustomPermission;\n", 
                        "use CustomPermission;\n" 
                    ], 
                    ['', ''], 
                    $from
                );
                file_put_contents($to['file'], $from);
                $mainFile = str_replace(base_path() . '/', '', $to['file']);
                 
                $this->info("This file {$mainFile} is updated successfully!");
            }

            if ((file_exists($to['file']) && strpos($to['file'], ReusableLibEnum::SEEDER_MAIN_FILE) !== false)) {
                $from = file_get_contents($to['file']);
                $from = str_replace([
                    //'$this->call([',
                    'PermissionSeeder::class,',
                    'RoleSeeder::class,',
                    'UserSeeder::class',
                    //']);', 
                ], ['', '', ''], $from); 

                file_put_contents($to['file'], $from);
                $mainFile = str_replace(base_path() . '/', '', $to['file']);
                 
                $this->info("This file {$mainFile} is updated successfully!");
            }
        }
    }

    protected function fileContentList()
    {
        return [
            ['file' => app_path('Models/User.php')],
            ['file' => base_path('database/seeders/DatabaseSeeder.php')]
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
            ['file' => app_path('Http/Middleware/AuthGates.php')],
            ['file' => base_path('database/seeders/PermissionSeeder.php')],
            ['file' => base_path('database/seeders/RoleSeeder.php')],
            ['file' => base_path('database/seeders/UserSeeder.php')]
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
            'create_permissions_table.php' => 'create_permissions_table.php',
            'create_roles_table.php' => 'create_roles_table.php',
            'create_permission_role_table.php' => 'create_permission_role_table.php',
            'create_role_user_table.php' => 'create_role_user_table.php',
        ];
    }

}