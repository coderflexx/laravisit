<?php

namespace Coderflex\Laravisit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Coderflex\Laravisit\Laravisit
 */
class Laravisit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravisit';
    }
}
