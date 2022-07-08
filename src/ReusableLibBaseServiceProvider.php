<?php 

namespace Bjit\ReusableLib;

use Bjit\ReusableLib\Console\AllBjitMakeCommand;
use Bjit\ReusableLib\Console\AllBjitRemoveCommand;
use Bjit\ReusableLib\Console\Commands\AuthorizationInstallCommand;
use Bjit\ReusableLib\Console\Commands\AuthorizationRemoveCommand; 
use Bjit\ReusableLib\Console\Commands\BoilerplateInstallCommand;
use Bjit\ReusableLib\Console\Commands\BoilerplateRemoveCommand;
use Bjit\ReusableLib\Console\Commands\BlogInstallCommand;
use Bjit\ReusableLib\Console\Commands\BlogRemoveCommand;
use Bjit\ReusableLib\Console\Commands\CentralizedMultipleFileInstallCommand;
use Bjit\ReusableLib\Console\Commands\CentralizedMultipleFileRemoveCommand;
use Bjit\ReusableLib\Console\Commands\NotificationInstallCommand;
use Bjit\ReusableLib\Console\Commands\NotificationRemoveCommand;
use Bjit\ReusableLib\Console\RepositoryBjitMakeCommand;
use Bjit\ReusableLib\Console\ReusableLibInstallCommand;
use Bjit\ReusableLib\Console\ReusableLibRemoveCommand;
use Bjit\ReusableLib\Console\ServiceBjitMakeCommand;
use Illuminate\Support\ServiceProvider;

class ReusableLibBaseServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->registerResources(); 
    }

    public function boot()
    {
        $this->bootCommands();
    }

    protected function registerResources()
    {

    }

    protected function bootCommands()
    {
        $this->commands([ 
            RepositoryBjitMakeCommand::class,
            ServiceBjitMakeCommand::class, 
            AllBjitMakeCommand::class,
            AllBjitRemoveCommand::class,
            ReusableLibInstallCommand::class,
            ReusableLibRemoveCommand::class,
            BoilerplateInstallCommand::class,
            BoilerplateRemoveCommand::class,
            AuthorizationInstallCommand::class,
            AuthorizationRemoveCommand::class,  
            BlogInstallCommand::class,
            BlogRemoveCommand::class,
            CentralizedMultipleFileInstallCommand::class,
            CentralizedMultipleFileRemoveCommand::class,
            NotificationInstallCommand::class,
            NotificationRemoveCommand::class,
            
        ]);
    }

}