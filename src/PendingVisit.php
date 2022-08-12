<?php

namespace Coderflex\Laravisit;

use Coderflex\Laravisit\Concerns\SetsPendingIntervals;
use Coderflex\Laravisit\Exceptions\InvalidDataException;
use Coderflex\Laravisit\Exceptions\VisitException;
use Coderflex\Laravisit\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class PendingVisit
{
    use SetsPendingIntervals;
    /**
     * @var array
     *
     */
    protected $attributes = [];

    public $isCrawler = false;

    public function __construct(protected Model $model)
    {
        if (!$model instanceof \Coderflex\Laravisit\Concerns\CanVisit) {
            throw VisitException::interfaceNotImplemented($model);
        }

        $crawlerDetect = new CrawlerDetect(request()->headers->all(), request()->header('User-Agent'));

        $this->isCrawler = $crawlerDetect->isCrawler();

        // set daily intervals by default
        $this->dailyIntervals();
    }

    /**
     * Set IP attribute
     *
     * @param string $ip
     * @return $this
     */
    public function withIP(string $ip = null): self
    {
        $this->attributes['ip'] = $ip ?? request()->ip();

        return $this;
    }

    /**
     * Set Custom Data attribute
     *
     * @param array $data
     * @return $this
     */
    public function withData(array $data): self
    {
        if (!count($data)) {
            throw new InvalidDataException('The data argument cannot be empty');
        }

        $this->attributes = array_merge($this->attributes, $data);

        return $this;
    }

    /**
     * Set User attribute
     *
     * @param Model $user
     * @return $this
     */
    public function withUser(Model $user = null): self
    {
        $this->attributes['user_id'] = $user?->id ?? auth()->id();

        return $this;
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

        return !$visit->wasRecentlyCreated &&
            $visit->created_at->lt($this->interval);
    }

    public function __destruct()
    {
        if (!$this->isCrawler) {
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
}
