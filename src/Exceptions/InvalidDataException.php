<?php

namespace Coderflex\Laravisit\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
   /**
    * Exception handling message
    *
    * @var string $message
    */
    protected $message = 'The incoming data was invalid';

   /**
    * Exception handling status code
    *
    * @var string $code
    */
    protected $code = 500;
}
