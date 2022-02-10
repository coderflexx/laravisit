<?php

use Carbon\Carbon;
use Coderflex\Laravisit\Tests\Models\Post;

it('gets the total visits count', function () {
    $post = Post::factory()->create();

    $post->visit();

    $post = Post::withTotalVisitCount()->first();

    expect($post->visit_count_total)->toEqual(1);
});

it('gets records popular all time', function () {
    Post::factory()
            ->times(2)
            ->create()
            ->each->visit();
    $popularPost = Post::factory()->create();


    Carbon::setTestNow(now()->subDays(2));
    $popularPost->visit();

    Carbon::setTestNow();
    $popularPost->visit();

    $posts = Post::popularAllTime()->get();

    expect($posts->count())->toBe(3);

    expect($posts->first()->visit_count_total)->toEqual(2);
});
