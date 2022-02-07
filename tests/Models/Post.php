<?php

namespace Coderflex\Laravisit\Tests\Models;

use Coderflex\Laravisit\Concerns\Visitable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use Visitable;

    protected $fillable = ['name'];
}
