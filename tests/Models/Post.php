<?php

namespace Coderflex\Laravisit\Tests\Models;

use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasVisits;

    protected $guarded = [];
}
