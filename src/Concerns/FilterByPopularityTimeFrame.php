<?php

namespace Coderflex\Laravisit\Concerns;

use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Filter By Popularity Time Frame
 */
trait FilterByPopularityTimeFrame
{
    /**
     * Get the total visit count
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTotalVisitCount(Builder $builder): Builder
    {
        return $builder->withCount('visits as visit_count_total');
    }

    /**
     * Get the popular visits all time
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularAllTime(Builder $builder): Builder
    {
        return $builder->withTotalVisitCount()
                        ->orderBy('visit_count_total', 'desc');
    }

    /**
     * Get the popular visits between two dates
     *
     * @param Builder $builder
     * @param Carbon $from
     * @param Carbon $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularBetween(Builder $builder, Carbon $from, Carbon $to): Builder
    {
        return $builder->whereHas('visits', $this->betweenScope($from, $to))
                        ->withCount([
                            'visits as visit_count' => $this->betweenScope($from, $to),
                        ]);
    }

    /**
     * Get the popular visits between two dates
     *
     * @param Carbon $from
     * @param Carbon $to
     * @return Closure
     */
    protected function betweenScope(Carbon $from, Carbon $to): Closure
    {
        return fn ($query) => $query->whereBetween('created_at', [$from, $to]);
    }
}
