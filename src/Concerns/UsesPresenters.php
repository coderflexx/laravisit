<?php

namespace Coderflex\Laravisit\Concerns;

use Coderflex\Laravisit\Exceptions\PresenterException;

/**
 * Uses Presenters Trait
 */
trait UsesPresenters
{
    /**
     * Check the given presenters value exists or not
     *
     * @param string $type
     * @return void
     */
    public function present(string $type = 'default')
    {
        if (array_key_exists($type, $this->presenters)) {
            return new $this->presenters[$type]($this);
        }

        throw new PresenterException();
    }
}
