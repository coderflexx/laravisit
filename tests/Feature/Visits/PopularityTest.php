<?php

use Coderflex\Laravisit\Tests\Models\Post;

it('gets the total visits count', function () {
    $post = Post::factory()->create();

    $post->visit();

    $post = Post::withTotalVisitCount()->first();

    expect($post->visit_count_total)->toEqual(1);
});
