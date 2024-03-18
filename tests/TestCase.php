<?php

namespace Coderflex\Laravisit\Tests;

use Coderflex\Laravisit\LaravisitServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupDatabases($this->app);

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

    public function setupDatabases($app)
    {
        Schema::dropAllTables();

        // load laravisits migration
        $migration = include __DIR__ . '/../database/migrations/create_laravisits_table.php.stub';
        $migration->up();

        // Load posts migration
        $migration = include __DIR__.'/Database/Migrations/create_posts_table.php';
        $migration->up();

        // load users migration
        $migration = include __DIR__.'/Database/Migrations/create_users_table.php';
        $migration->up();
    }
}
