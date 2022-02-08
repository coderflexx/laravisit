<?php

use Coderflex\Laravisit\Tests\Models\Post;

it('can create a post', function () {
    $post = Post::factory()->create();

    expect($post->count())->toEqual(1);
});

it('has a name', function () {
    $post = Post::factory()->create(['name' => 'Laravel']);

    expect($post->name)->toEqual('Laravel');
});
