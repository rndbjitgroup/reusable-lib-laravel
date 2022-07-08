<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CentralizedMultipleFileRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:centralized-multiple-file-remove {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files of Centralized Multiple File that are available';
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
            $this->info('Centralized Multiple File is removed successfully.');
        } else {
            $this->info('There is no change in Centralized Multiple File.');
        }  
    }

    protected function handleRemove()
    {
        $this->runRemoveExecCommands(); 
        $this->deleteMigrationFiles();
        $this->deleteExtraDirecotriesOrFiles();
        $this->removeDirectory();  
        $this->removeOtherDirectory();
    }

    protected function removeDirectory()
    {
        $directory =  $this->arrangeDirectory('Products'); 
 
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
            ['path' => app_path('Repositories/' . $path)],
            ['path' => app_path('Services/' . $path)],
            ['path' => app_path('Http/Resources/' . $path)],
            ['path' => app_path('Http/Requests/' . $path)],
            ['path' => app_path('Http/Controllers/Api/' . $path)],
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
            'create_files_table.php' => 'create_files_table.php',
            'create_product_categories_table.php' => 'create_product_categories_table.php',
            'create_products_table.php' => 'create_products_table.php', 
            'create_tags_table.php' => 'create_tags_table.php', 
            'create_product_tag_table.php' => 'create_product_tag_table.php', 
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
            ['file' => app_path('Models/Common/File.php')], 
        ];
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

    protected function otherDirectory()  
    {
        return [
            ['path' => app_path('Models/Common')], 
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