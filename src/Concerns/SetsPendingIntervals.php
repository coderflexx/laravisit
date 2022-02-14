<?php

namespace Coderflex\Laravisit\Concerns;

use Carbon\Carbon;

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
     * Interval available functions
     * key (method) => the name of carbon interval method
     * @var array
     */
    protected static $intervalsFunc = [
        'hourlyIntervals' => 'subHour',
        'dailyIntervals' => 'subDay',
        'weeklyIntervals' => 'subWeek',
        'monthlyIntervals' => 'subMonth',
        'yearlyIntervals' => 'subYear',
    ];

    /**
     * Set Time Intervals
     *
     * @return mixed
     */
    public function __call($name, $arguments): mixed
    {
        try {
            $timezone = count($arguments) ? $arguments[0] : null;
            $method = self::$intervalsFunc[$name];

            $this->interval = Carbon::now($timezone)->$method();

            return $this;
        } catch (\Throwable $th) {
            return __('Error: Method :name does not exists,  :message', [
                'name' => $name,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Set Custom Interval
     *
     * @param mixed $interval
     * @return self
     */
    public function customInterval(mixed $interval): self
    {
        $this->interval = $interval instanceof Carbon
                            ? $interval
                            : Carbon::parse($interval);

        return $this;
    }
}
