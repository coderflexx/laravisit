<?php

namespace Coderflex\Laravisit\Exceptions;

use Exception;

class PresenterException extends Exception
{
    /**
     * Exception handling message
     *
     * @var string
     */
    protected $message = 'Presenter not found';

    /**
     * Exception handling status code
     *
     * @var int
     */
    protected $code = 500;
}

