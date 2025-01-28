<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Utils\CmnUtil;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem; 

class BlogInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:blog-install {--auth= : Auth type } {--case= : letter case } {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all stubs of Blog that are available';
    protected $execCommands = [];
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleInstallation();
        $this->info('Blog all files is installed successfully.');
    }

    protected function handleInstallation()
    {
        //$this->runExecCommands();
        $this->installFiles(); 
        $this->updateFileContent(); 
    } 

    // protected function runExecCommands()
    // {
    //     $this->setExecCommands();
    //     if (function_exists('exec')) { 
    //         foreach($this->execCommands as $execCommand) {
    //             exec('cd ' . base_path() . ' && ' . $execCommand); 
    //         }
    //         exec('cd ' . base_path() . ' && ' . ReusableLibEnum::COMPOSER_AUTOLOAD);
    //         $this->info('The Commands are run successfully.');
    //     } else {
    //         $this->error($this->prepareErrorMessage());
    //     } 
    // }

    // protected function setExecCommands()
    // {
    //     $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_IMAGE_RESIZE;
    // }

    // protected function prepareErrorMessage()
    // {
    //     $rtrText =  "Please run below commands \n";
    //     if(empty($this->execCommands)) {
    //         return false;
    //     }

    //     foreach($this->execCommands as $execCommand) {
    //         $rtrText .= $execCommand . " \n";
    //     }
    //     return $rtrText;
    // }

    protected function installFiles()
    {
        $files = $this->blogFiles();  
        $files = array_merge($files, $this->databaseFiles()); 
 
        foreach ($files as $from => $to) { 
            if ( ! is_dir($stubsPath = $to['path'])) {  
                (new Filesystem)->makeDirectory($stubsPath, 0777, true);
            }  
             
            if ( ! file_exists($to['file'])  
                || str_contains($to['file'], ReusableLibEnum::MODEL_USER)
                || str_contains($to['file'], ReusableLibEnum::CONFIG_APP)
                || $this->option('force')) {
                     
                    if ($this->option('auth') === ReusableLibEnum::API_AUTH_NONE) {
                        if (strpos($to['file'], 'Controller') !== false 
                            || strpos($to['file'], 'Request') !== false) {

                            $from = str_replace(
                                [
                                    'security={{"bearerAuth": {}}},',
                                    'Gate::authorize(\'category-list\');',
                                    'Gate::authorize(\'category-view\');',
                                    'Gate::authorize(\'category-delete\');',
                                    'Gate::allows(\'category-create\')',
                                    'Gate::allows(\'category-edit\')',
                                    'Gate::authorize(\'comment-list\');',
                                    'Gate::authorize(\'comment-view\');',
                                    'Gate::authorize(\'comment-delete\');',
                                    'Gate::allows(\'comment-create\')',
                                    'Gate::allows(\'comment-edit\')',
                                    'Gate::authorize(\'post-list\');',
                                    'Gate::authorize(\'post-view\');',
                                    'Gate::authorize(\'post-delete\');',
                                    'Gate::allows(\'post-create\')',
                                    'Gate::allows(\'post-edit\')',
                                    'Gate::allows(\'comment-reply\')',
                                    'Gate::allows(\'post-update\')'
                                ], 
                                [
                                    '', '', '', '', 'true', 'true',
                                    '', '', '', 'true', 'true',
                                    '', '', '', 'true', 'true',
                                    'true', 'true'
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

    protected function blogFiles()
    {
        $files = $this->arrangeFiles('Models');
        $files = array_merge($files, $this->arrangeFiles('Interfaces')); 
        $files = array_merge($files, $this->arrangeFiles('Traits'));  
        $files = array_merge($files, $this->arrangeFiles('Repositories'));  
        $files = array_merge($files, $this->arrangeFiles('Services'));  
        $files = array_merge($files, $this->arrangeFiles('Http/Resources')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Requests')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API'));

        return $files;
    }

    public function arrangeFiles($path, $module = 'Blogs', $isModuleEnabled = true)
    {
        $rtrArr = [];
        $stubPath = __DIR__ . '/../stubs/SimpleBlogs/' . $module . '/' . $path;
        $files = (new Filesystem)->files($stubPath);
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
            
            foreach ($files as $file) {  
                $fileName = str_replace(['.stub', '.camelCase'], ['.php', ''], $file->getFilename());
                $installedAppPath = $path;
                if(!str_contains($fileName, ReusableLibEnum::MODEL_USER)) {
                    $installedAppPath = $path . '/' . $module;
                }

                if (! file_exists(app_path( $path . '/' . $file->getFilename())) 
                    || str_contains($fileName, ReusableLibEnum::MODEL_USER)
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
            } 
        } 
        return $rtrArr;
    }
    

    protected function databaseFiles()
    {
        $files = $this->migrationFiles();
        return $files;
    }

    protected function migrationFiles()
    {
        $rtrArr = [];
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/SimpleBlogs/database/migrations');
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
            foreach ($files as $file) {  
                $mTime = time();
                if(str_contains($file->getFilename(), 'comments')) {
                    $mTime += 1;
                }
                $fileName = str_replace('.stub', '.php', $file->getFilename());
                if ($this->option('force') || ! CmnUtil::fileExistsWithPattern(base_path('database/migrations/' . '*' . $fileName))) {
                    $rtrArr[$file->getPathInfo() . '/' . $file->getFilename()] = [
                        'path' => base_path('database/migrations'),
                        'file' => base_path('database/migrations') . '/' . date('Y_m_d_His', $mTime) . '_' . $fileName
                    ];
                }
            } 
        }
        return $rtrArr;
    } 

    protected function updateFileContent()
    {
        //--- UPDATE app/Models/User.php ---
        if (file_exists(app_path('Models/User.php'))) {
            $userModelFile = str_replace(
                [
                    '//use App\Traits\Blogs\CustomBlog;',
                    '//use CustomBlog;'
                ], 
                [
                    'use App\Traits\Blogs\CustomBlog;',
                    'use CustomBlog;'
                ],
                file_get_contents(app_path('Models/User.php'))
            ); 
            file_put_contents(app_path('Models/User.php'), $userModelFile);
            $this->info('This app/Models/User.php file is updated successfully!');
        }

    } 

}