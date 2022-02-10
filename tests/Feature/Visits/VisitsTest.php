<?php

use Coderflex\Laravisit\Exceptions\InvalidDataException;
use Coderflex\Laravisit\Tests\Models\Post;
use Coderflex\Laravisit\Tests\Models\User;

it('can create a visit', function () {
    $post = Post::factory()->create();

    $post->visit();

    expect($post->visits->count())->toBe(1);
});

it('creates a visit with the default ip address', function () {
    $post = Post::factory()->create();

    $post->visit()->withIp();

    expect($post->visits->first()->data)
        ->toMatchArray([
            'ip' => request()->ip(),
        ]);
});

it('creates a visit with the given ip address', function () {
    $post = Post::factory()->create();

    $post->visit()->withIp('10.10.10.10');

    expect($post->visits->first()->data)
        ->toMatchArray([
            'ip' => '10.10.10.10',
        ]);
});

it('gets the correct ip when creating a visit', function () {
    $post = Post::factory()->create();

    $post->visit()->withIp();

    expect($post->visits->first()->present()->ip)
        ->toEqual(request()->ip());
});

it('creates a visit with custom data', function () {
    $post = Post::factory()->create();

    $post->visit()->withData([
        'outside_region' => true,
    ]);

    expect($post->visits->first()->data)
        ->toMatchArray([
            'outside_region' => true,
        ]);
});

it('excepts an error when creating a visit with an empty data', function () {
    $post = Post::factory()->create();
    $post->visit()->withData([]);
})->throws(
    InvalidDataException::class,
    'The data argument cannot be empty'
);

it('creates a visit with a default user', function () {
    $this->actingAs($user = User::factory()->create());
    $post = Post::factory()->create();

    $post->visit()->withUser();

    expect($post->visits->first()->data)
        ->toMatchArray([
            'user_id' => $user->id,
        ]);
});

it('creates a visit with a given user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $post->visit()->withUser($user);

    expect($post->visits->first()->data)
        ->toMatchArray([
            'user_id' => $user->id,
        ]);
});


it('gets the associated user when creating a visit', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $post->visit()->withUser($user);

    expect($post->visits->first()->present()->user->name)
        ->toEqual($user->name);
});

it('does note create duplicate visits with the same data', function () {
    $post = Post::factory()->create();

    $post->visit()->withData([
        'outside_region' => true,
    ]);

    $post->visit()->withData([
        'outside_region' => true,
    ]);

    expect($post->visits->first()->count())->toBe(1);
});

it('does not create visits within the same time frame', function () {
    $post = Post::factory()->create();

    Carbon::setTestNow(now()->subDays(2));

    $post->visit();

    Carbon::setTestNow();

    $post->visit();
    $post->visit();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after an hourly time frame', function () {
    $post = Post::factory()->create();

    $post->visit()->hourlyIntervals()->withIp();

    Carbon::setTestNow(now()->addHour()->addMinute());

    $post->visit()->hourlyIntervals()->withIp();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after a weekly time frame', function () {
    $post = Post::factory()->create();

    $post->visit()->weeklyIntervals()->withIp();

    Carbon::setTestNow(now()->addWeek());

    $post->visit()->weeklyIntervals()->withIp();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after a monthly time frame', function () {
    $post = Post::factory()->create();

    $post->visit()->monthlyIntervals()->withIp();

    Carbon::setTestNow(now()->addMonth());

    $post->visit()->monthlyIntervals()->withIp();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after a yearly time frame', function () {
    $post = Post::factory()->create();

    $post->visit()->yearlyIntervals()->withIp();

    Carbon::setTestNow(now()->addYear());

    $post->visit()->yearlyIntervals()->withIp();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after a carbon custom time frame', function () {
    $post = Post::factory()->create();

    $post->visit()
        ->customInterval(
            now()->subYear()
        )
        ->withIp();

    Carbon::setTestNow(now()->addYear());

    $post->visit()
        ->customInterval(
            now()->subYear()
        )
        ->withIp();

    expect($post->visits->first()->count())->toBe(2);
});

it('creates visits after a non-carbon custom time frame', function () {
    $post = Post::factory()->create();
    $time = strtotime("-1 year", time());
    $date = date("Y-m-d", $time);

    $post->visit()
        ->customInterval(
            $date
        )
        ->withIp();

    expect($post->visits->first()->count())->toBe(1);
});

