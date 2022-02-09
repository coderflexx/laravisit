<?php

use Coderflex\Laravisit\Tests\Models\Post;

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