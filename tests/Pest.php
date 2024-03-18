<?php

use Coderflex\Laravisit\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class)->in(__DIR__);

beforeEach()->setupDatabases();
