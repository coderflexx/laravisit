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

