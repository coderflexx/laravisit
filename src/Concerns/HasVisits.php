<?php

namespace Coderflex\Laravisit\Concerns;

use Coderflex\Laravisit\Models\Visit;
use Coderflex\Laravisit\PendingVisit;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Has Visits Relation
 */
trait HasVisits
{
    use FilterByPopularityTimeFrame;

    /**
     * keep track of your pages
     *
     * @return PendingVisit
     */
    public function visit(): PendingVisit
    {
        return new PendingVisit($this);
    }

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
