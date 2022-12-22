<?php

namespace Coderflex\Laravisit\Models;

use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Coderflex\Laravisit\Presenters\VisitPresenter;
use Illuminate\Database\Eloquent\Model;

/**
 * Coderflex\Laravisit\Models\Visit
 * @property int $id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Visit extends Model implements CanPresent
{
    use UsesPresenters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "laravisits";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * The classes that should be present
     *
     * @var array
     */
    protected $presenters = [
        'default' => VisitPresenter::class,
    ];

    public function visitable()
    {
        return $this->morphTo();
    }

    public function resetHits()
    {
        $this->fill(['data->hits' => 1]);
        $this->save();
    }

    public function incrementHits()
    {
        $this->fill(['data->hits' => $this->hits + 1]);
        $this->save();
    }

    public function getHitsAttribute()
    {
        return is_numeric($this->data['hits'] ?? null) ? $this->data['hits'] : 1;
    }
}
