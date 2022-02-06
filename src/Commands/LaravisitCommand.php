<?php

namespace Coderflex\Laravisit\Commands;

use Illuminate\Console\Command;

class LaravisitCommand extends Command
{
    public $signature = 'laravisit';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
