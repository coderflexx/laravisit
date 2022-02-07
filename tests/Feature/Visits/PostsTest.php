<?php

use Coderflex\Laravisit\Tests\Models\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

it('has visits relationship', function () {
    $post = Post::factory()->create();

    expect($post->visits())->toBeInstanceOf(MorphMany::class);
});
