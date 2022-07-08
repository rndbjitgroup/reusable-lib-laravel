<?php 

namespace Bjit\ReusableLib\Console\Commands;

use Bjit\ReusableLib\Enums\ReusableLibEnum;
use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class NotificationRemoveCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bjit:notification-remove {--force : Overwrite any existing files}';

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
        //$this->deleteMigrationFiles();
        $this->removeDirectory(); 
        $this->deleteExtraDirecotriesOrFiles();
        $this->removeOtherDirectory();
        $this->removeFileContent();  
    }

    protected function removeDirectory()
    {
        $directory =  $this->arrangeDirectory('Notifications');
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
            //['path' => app_path('Notifications/' . $path)],  
            //['path' => app_path('Events/' . $path)],  
            ['path' => app_path('Services/' . $path)],
            //['path' => app_path('Http/Resources/' . $path)],
            //['path' => app_path('Http/Requests/' . $path)],
            ['path' => app_path('Http/Controllers/Api/' . $path)],
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
            ['file' => app_path('Notifications/SendBothNotification.php')], 
            ['file' => app_path('Notifications/SendDatabaseNotification.php')],
            ['file' => app_path('Notifications/SendEmailNotification.php')],
            ['file' => app_path('Events/SendPushMessage.php')],
            ['file' => app_path('Events/SendPushRandomMessage.php')],
            ['file' => base_path('laravel-echo-server.json')],
        ];
    }

    protected function removeFileContent()
    {
        $files = $this->fileContentList();
        foreach ($files as $from => $to) {  
            if (file_exists($to['file']) || $this->option('force')) {
                $from = file_get_contents($to['file']);
                if (str_contains($to['file'], ReusableLibEnum::CONFIG_BROADCASTING)) {
                    $from = str_replace(
                        [
                            "'host' => '127.0.0.1',\n", 
                            "'port' => 6001,\n",
                            "'scheme' => 'http'",  
                        ], 
                        ['', '', ''], 
                        $from
                    );
                } 
                file_put_contents($to['file'], $from);
                $mainFile = str_replace(base_path() . '/', '', $to['file']);
                $this->info("This file {$mainFile} is updated successfully!");
            } 
        }
    }

    protected function fileContentList()
    {
        return [
            //['file' => app_path('Models/User.php')],
            ['file' => config_path('broadcasting.php')]
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
        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_REMOVE_WEBSOCKET;
        $this->execCommands[] = ReusableLibEnum::COMPOSER_AUTOLOAD;
        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_REMOVE_PUSHER;
        $this->execCommands[] = ReusableLibEnum::COMPOSER_COMMAND_REMOVE_PSR7; 
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
            ['path' => app_path('Notifications')],
            ['path' => app_path('Events')] 
        ];
    } 

}