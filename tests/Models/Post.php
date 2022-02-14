<?php

namespace Coderflex\Laravisit\Tests\Models;

use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Coderflex\Laravisit\Tests\Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements CanVisit
{
    use HasFactory;
    use HasVisits;

    protected $guarded = [];

    protected static function newFactory()
    {
        return PostFactory::new();
    }
}
