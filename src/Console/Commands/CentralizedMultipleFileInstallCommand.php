<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use Bjit\ReusableLib\Utils\CmnUtil;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem; 

class CentralizedMultipleFileInstallCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:centralized-multiple-file-install {--auth= : Auth type } {--case= : letter case } {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all stubs of Centralized Multiple File that are available';
    protected $execCommands = [];
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleInstallation();
        $this->info('Centralized Multiple File\'s all files is installed successfully.');
    }

    protected function handleInstallation()
    { 
        $this->installFiles();  
    } 

    protected function installFiles()
    {
        $files = $this->productFiles();  
        $files = array_merge($files, $this->databaseFiles());  
 
        foreach ($files as $from => $to) { 
            if ( ! is_dir($stubsPath = $to['path'])) {  
                (new Filesystem)->makeDirectory($stubsPath, 0777, true);
            }  
             
            if ( ! file_exists($to['file'])  
                //|| str_contains($to['file'], ReusableLibEnum::MODEL_USER)
                //|| str_contains($to['file'], ReusableLibEnum::CONFIG_APP)
                || $this->option('force')) {
                     
                    if ($this->option('auth') === ReusableLibEnum::API_AUTH_NONE) {
                        if (strpos($to['file'], 'Controller') !== false 
                            || strpos($to['file'], 'Request') !== false) {

                            $from = str_replace(
                                [
                                    'security={{"bearerAuth": {}}},',
                                    'Gate::authorize(\'product-category-list\');',
                                    'Gate::authorize(\'product-category-view\');',
                                    'Gate::authorize(\'product-category-delete\');',
                                    'Gate::allows(\'product-category-create\')',
                                    'Gate::allows(\'product-category-edit\')', 
                                    'Gate::authorize(\'product-list\');',
                                    'Gate::authorize(\'product-view\');',
                                    'Gate::authorize(\'product-delete\');',
                                    'Gate::allows(\'product-create\')',
                                    'Gate::allows(\'product-edit\')',  
                                ], 
                                [
                                    '', '', '', '', 'true', 'true',
                                    '', '', '', 'true', 'true', 
                                ],
                                file_get_contents($from)
                            ); 
                        } else {
                            $from = file_get_contents($from);
                        } 
                    } else {
                        $from = file_get_contents($from);
                    }

                    file_put_contents($to['file'], $from);
                    $mainFile = str_replace(base_path() . '/', '', $to['file']);
                    $this->info("This file {$mainFile} is installed successfully!");
            }
        }
    }

    protected function productFiles()
    {
        $files = $this->arrangeFiles('Models');  
        $files = array_merge($files, $this->arrangeFiles('Models', 'Common')); 
        $files = array_merge($files, $this->arrangeFiles('Interfaces'));
        $files = array_merge($files, $this->arrangeFiles('Repositories'));  
        $files = array_merge($files, $this->arrangeFiles('Services'));  
        $files = array_merge($files, $this->arrangeFiles('Http/Resources')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Resources', 'Common')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Requests')); 
        $files = array_merge($files, $this->arrangeFiles('Http/Controllers/API'));

        return $files;
    }

    public function arrangeFiles($path, $module = 'Products', $isModuleEnabled = true)
    {
        $rtrArr = [];
        $stubPath = __DIR__ . '/../stubs/CentralizedMultipleFile/' . $module . '/' . $path;
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
        $files = (new Filesystem)->files(__DIR__ . '/../stubs/CentralizedMultipleFile/database/migrations');
         
        if (!empty($files) && count($files) > ReusableLibEnum::DEFAULT_ZERO) {
            
            foreach ($files as $file) {  
                $mTime = time() + ReusableLibEnum::DEFAULT_ONE;
                if(str_contains($file->getFilename(), 'product_tag')) {
                    $mTime += ReusableLibEnum::DEFAULT_TWO;
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

}