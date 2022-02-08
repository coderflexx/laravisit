<?php

namespace Coderflex\Laravisit;

use Coderflex\Laravisit\Commands\LaravisitCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravisitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravisit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravisits_table')
            ->hasCommand(LaravisitCommand::class);
    }
}
