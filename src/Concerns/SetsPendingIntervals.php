<?php

namespace Coderflex\Laravisit\Concerns;

/**
 * Pending Intervals TraitName
 */
trait SetsPendingIntervals
{
    /**
     * @var \Carbon\Carbon
     *
     */
    protected $interval;

    /**
     * Set Hourly Intervals
     *
     * @return self
     */
    public function hourlyIntervals(): self
    {
        $this->interval = now()->subHour();

        return $this;
    }

    /**
     * Set Daily Intervals
     *
     * @return self
     */
    public function dailyIntervals(): self
    {
        $this->interval = now()->subDay();

        return $this;
    }
}
