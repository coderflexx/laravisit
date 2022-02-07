<?php

namespace Coderflex\Laravisit\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function visitable()
    {
        return $this->morphTo();
    }
}
