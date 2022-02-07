<?php

namespace Coderflex\Laravisit\Concerns;

use Coderflex\Laravisit\Models\Visit;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Has Visits Relation
 */
trait Visitable
{
    /**
     * Has Visits relationship many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function visits(): MorphToMany
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
