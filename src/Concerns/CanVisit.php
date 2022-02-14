<?php

namespace Coderflex\Laravisit\Concerns;

interface CanVisit
{
    /**
     * keep track of your pages
     *
     * @return PendingVisit
     */
    public function visit();

    /**
     * Has Visits relationship many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function visits();
}
