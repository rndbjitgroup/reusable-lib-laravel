<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BlogRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:blog-remove {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files of Blog that are available';
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
            $this->info('Blog is removed successfully.');
        } else {
            $this->info('There is no change in Blog.');
        }  
    }

    protected function handleRemove()
    {
        $this->runRemoveExecCommands(); 
        $this->deleteMigrationFiles();
        $this->removeDirectory(); 
        $this->removeFileContent();  
    }

    protected function removeDirectory()
    {
        $directory =  $this->arrangeDirectory('Blogs');
        //$directory = array_merge($directory, $this->arrangeDirectory('another')); 
 
        foreach ($directory as $to) { 
            if (! is_dir($directoryPath = $to['path'])) {  
                continue;
            }   
            (new Filesystem)->deleteDirectory($directoryPath);
            $mainPath = str_replace(base_path() . '/', '', $directoryPath);
            $this->info("This path {$mainPath} is removed successfully!");
        }
        
    } 

    protected function arrangeDirectory($path)
    {
        return [ 
            ['path' => app_path('Models/' . $path)],
            ['path' => app_path('Traits/' . $path)],
            ['path' => app_path('Repositories/' . $path)],
            ['path' => app_path('Services/' . $path)],
            ['path' => app_path('Http/Resources/' . $path)],
            ['path' => app_path('Http/Requests/' . $path)],
            ['path' => app_path('Http/Controllers/Api/' . $path)],
        ];
    } 

    protected function removeFileContent()
    {
        $files = $this->fileContentList();
        foreach ($files as $from => $to) {  
            if (file_exists($to['file']) || $this->option('force')) {
                $from = file_get_contents($to['file']);
                if (str_contains($to['file'], ReusableLibEnum::MODEL_USER)) {
                    $from = str_replace(
                        [
                            "//use App\Traits\Blogs\CustomBlog;\n", 
                            "//use CustomBlog;\n",
                            "use App\Traits\Blogs\CustomBlog;\n", 
                            "use CustomBlog;\n" 
                        ], 
                        ['', ''], 
                        $from
                    );
                }
                // if (str_contains($to['file'], ReusableLibEnum::CONFIG_APP)) {
                //     $from = str_replace(
                //         [
                //             "Intervention\Image\ImageServiceProvider::class,", 
                //             "'Image' => Intervention\Image\Facades\Image::class,"
                //         ], 
                //         ['', ''], 
                //         $from
                //     );
                // }
                // file_put_contents($to['file'], $from);
                $mainFile = str_replace(base_path() . '/', '', $to['file']);
                 
                $this->info("This file {$mainFile} is updated successfully!");
            }
        }
    }

    protected function fileContentList()
    {
        return [
            ['file' => app_path('Models/User.php')],
            //['file' => config_path('app.php')]
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
            'create_categories_table.php' => 'create_categories_table.php',
            'create_posts_table.php' => 'create_posts_table.php',
            'create_comments_table.php' => 'create_comments_table.php', 
        ];
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
        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_REMOVE_IMAGE_RESIZE;
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

}