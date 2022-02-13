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

it('gets popular records between two dates', function () {
    $posts = Post::factory()
                ->times(2)
                ->create();

    Carbon::setTestNow(Carbon::createFromDate(2020, 10, 10));
    $posts->first()->visit();

    Carbon::setTestNow();
    $posts->first()->visit();
    $posts->last()->visit();

    $popularPosts = Post::popularBetween(
        Carbon::createFromDate(2020, 10, 9),
        Carbon::createFromDate(2020, 10, 11),
    )->get();

    expect($popularPosts->count())->toBe(1);
    expect($popularPosts->first()->visit_count_total)->toEqual(1);
});

it('gets popular records last x days', function () {
    $post = Post::factory()->create();

    Carbon::setTestNow(now()->subDays(10));
    $post->first()->visit();

    Carbon::setTestNow();
    $post->first()->visit();

    $popularPosts = Post::popularLastDays(6)->get();

    expect($popularPosts->count())->toBe(1);
});

it('gets popular records by this week', function () {
    $posts = Post::factory()
        ->times(2)
        ->create();

    Carbon::setTestNow(now()->subWeek()->subDay());
    $posts->first()->visit();

    Carbon::setTestNow();
    $posts->last()->visit();

    $posts = Post::popularThisWeek()->get();

    expect($posts->count())->toBe(1);
});

it('gets popular records last week', function () {
    $posts = Post::factory()
        ->times(2)
        ->create();

    Carbon::setTestNow(now()->subDay(7)->startOfWeek());
    $posts->first()->visit();

    Carbon::setTestNow();
    $posts->last()->visit();

    $posts = Post::popularLastWeek()->get();

    expect($posts->count())->toBe(1);
});


