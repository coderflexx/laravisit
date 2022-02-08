<?php

namespace Coderflex\Laravisit;

use Coderflex\Laravisit\Concerns\SetsPendingIntervals;
use Coderflex\Laravisit\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    use SetsPendingIntervals;
    /**
     * @var array
     *
     */
    protected $attributes = [];

    public function __construct(protected Model $model)
    {
        $this->dailyIntervals();
    }

    /**
     * Build Json Columns from the given attribues
     *
     * @return array
     */
    protected function buildJsonColumns(): array
    {
        return collect($this->attributes)
                ->mapWithKeys(
                    fn ($value, $index) => ['data->' . $index => $value]
                )
                ->toArray();
    }

    /**
     * Make sure that we need to log the current record or not
     * based on the creation
     *
     * @param Visit $visit
     * @return bool
     */
    protected function shouldBeLoggedAgain(Visit $visit): bool
    {
        // Using wasRecentlyCreate model attribute
        // to check if the visit model was created
        // already or found.

        return ! $visit->wasRecentlyCreated &&
                $visit->created_at->lt($this->interval);
    }

    public function __destruct()
    {
        $visit = $this->model
                    ->visits()
                    ->latest()
                    ->firstOrCreate($this->buildJsonColumns(), [
                        'data' => $this->attributes,
                    ]);

        $visit->when(
            $this->shouldBeLoggedAgain($visit),
            function () use ($visit) {
                $visit->replicate()->save();
            }
        );
    }
}
