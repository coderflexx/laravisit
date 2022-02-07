<?php

namespace Coderflex\Laravisit\Concerns;

use Coderflex\Laravisit\Models\Visit;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Has Visits Relation
 */
trait Visitable
{
    /**
     * Has Visits relationship many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function visits(): MorphMany
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
