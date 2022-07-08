<?php 

namespace Bjit\ReusableLib\Tests;

use Bjit\ReusableLib\ReusableLibBaseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase 
{
    public function setUp(): void 
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ReusableLibBaseServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        
    }

}