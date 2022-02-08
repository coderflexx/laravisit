<?php

use Coderflex\Laravisit\Tests\Models\Post;

it('can create a visit', function () {
    
    $post = Post::factory()->create();

    $post->visit();

    expect($post->visits->count())->toBe(1);
});

