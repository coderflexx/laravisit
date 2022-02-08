<?php

namespace Coderflex\Laravisit\Tests;

use Coderflex\Laravisit\LaravisitServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Coderflex\\Laravisit\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravisitServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);


        $migration = include __DIR__.'/../database/migrations/create_posts_table.php';
        $migration->up();
        
        $migration = include __DIR__.'/../database/migrations/stubs/create_laravisits_table.php.stub';
        $migration->up();
    }
}
