<?php

namespace Coderflex\Laravisit\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class VisitException extends Exception
{
    /**
     * Method for Presenter Implementation absence on the model
     * @param Model $model
     * @return self
     */
    public static function interfaceNotImplemented(Model $model): self
    {
        return new self((
            __(':model should implements :interface interface', [
                'model' => get_class($model),
                'interface' => '\Coderflex\Laravisit\Concerns\CanVisit',
            ])
        ));
    }
}
