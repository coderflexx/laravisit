<?php

namespace Coderflex\Laravisit\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use Visitable;

    protected $fillable = ['name'];
}
