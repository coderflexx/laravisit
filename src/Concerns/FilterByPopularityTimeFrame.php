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
     * Get the popular visits today
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularToday(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfDay(),
            now()->endOfDay()
        );
    }

    /**
     * Get the popular visits last given days
     *
     * @param Builder $builder
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularLastDays(Builder $builder, int $days): Builder
    {
        return $builder->popularBetween(
            now()->subDays($days),
            now()
        );
    }

    /**
     * Get the popular visits this week
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularThisWeek(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfWeek(),
            now()->endOfWeek(),
        );
    }

    /**
     * Get the popular visits last week
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularLastWeek(Builder $builder): Builder
    {
        return $builder->popularBetween(
            $startOfLastWeek = now()->subDay(7)->startOfWeek(),
            $startOfLastWeek->copy()->endOfWeek()
        );
    }

    /**
     * Get the popular visits this month
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularThisMonth(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfMonth(),
            now()->endOfMonth(),
        );
    }

    /**
     * Get the popular visits last month
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularLastMonth(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfMonth()->subMonthWithoutOverflow(),
            now()->subMonthWithoutOverflow()->endOfMonth()
        );
    }

    /**
     * Get the popular visits this year
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularThisYear(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfYear(),
            now()->endOfYear(),
        );
    }

    /**
     * Get the popular visits last year
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularLastYear(Builder $builder): Builder
    {
        return $builder->popularBetween(
            now()->startOfYear()->subYearWithoutOverflow(),
            now()->subYearWithoutOverflow()->endOfYear()
        );
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
                            'visits as visit_count_total' => $this->betweenScope($from, $to),
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
