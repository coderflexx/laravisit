<?php

namespace Coderflex\Laravisit\Tests\Models;

use Coderflex\Laravisit\Concerns\HasVisits;
use Coderflex\Laravisit\Tests\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use HasVisits;

    protected $guarded = [];

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
