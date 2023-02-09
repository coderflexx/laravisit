<p align="center">
    <img src="docs/images/Logo.png" alt="Laravisit Logo" width="300">
    <br><br>
</p>

[![The Latest Version on Packagist](https://img.shields.io/packagist/v/coderflexx/laravisit.svg?style=flat-square)](https://packagist.org/packages/coderflexx/laravisit)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/coderflexx/laravisit/run-tests.yml?branch=main&label=tests)](https://github.com/coderflexx/laravisit/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/coderflexx/laravisit/phpstan.yml?branch=main&label=code%20style)](https://github.com/coderflexx/laravisit/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/coderflexx/laravisit.svg?style=flat-square)](https://packagist.org/packages/coderflexx/laravisit)

A clean way to track your pages & understand your user's behavior

## Installation

You can install the package via composer:

```bash
composer require coderflexx/laravisit
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Coderflex\\Laravisit\\LaravisitServiceProvider"
```

then, run database migration
```bash
php artisan migrate
```

This is the contents of the published config file:
```php
return [
    /*
    |--------------------------------------------------------------------------
    | User Namespace
    |--------------------------------------------------------------------------
    |
    | This value informs Laravisit which namespace you will be 
    | selecting to get the user model instance
    | If this value equals to null, "\Coderflex\Laravisit\Models\User" will be used 
    | by default.
    |
    */
    'user_namespace' => "\Coderflex\Laravisit\Models\User",
];
```


## Usage

### Use `HasVisits` Trait

The first thing you need  to do is, to use `HasVisits` trait, and implement `CanVisit` interface.

```php
namespace App\Models\Post;

use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements CanVisit
{
    ...
    use HasFactory;
    use HasVisits;
    ...
}
```
After this step, you are all set, you can now count visits by using `visit` method

```php
$post->visit();
```

You can chain methods to the `visit` method. Here are a list of the available methods:

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `withIp()`      | string `$ip = null`       | Set an Ip address (default `request()->ip()`)       | `$post->visit()->withIp()`       |
| `withSession()` | string `$session = null` | Set an Session ID (default `session()->getId()`) | `$post->visit()->withSession()` |
|`withData()` | array `$data` | Set custom data | `$post->visit()->withData(['region' => 'USA'])` |
| `withUser()` | Model `$user = null` | Set a user model (default `auth()->user()`) | `$user->visit()->withUser()` |

---

By default, you will have unique visits __each day__ using `dailyInterval()` method. Meaning, when the users access the page multiple times in a day time frame, you will see just `one record` related to them.

If you want to log users access to a page with different __timeframes__, here are a bunch of useful methods:

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `hourlyInterval()` | `void` | Log visits each hour | `$post->visit()->hourlyIntervals()->withIp();` |
| `dailyInterval()` | `void` | Log visits each day | `$post->visit()->dailyIntervals()->withIp();` |
| `weeklyInterval()` | `void` | Log visits each week | `$post->visit()->weeklyIntervals()->withIp();` |
| `monthlyInterval()` | `void` | Log visits each month | `$post->visit()->monthlyIntervals()->withIp();` |
| `yearlyInterval()` | `void` | Log visits each year | `$post->visit()->yearlyIntervals()->withIp();` |
| `customInterval()` | mixed `$interval` | Log visits within a custom interval | `$post->visit()->customInterval( now()->subYear() )->withIp();` |

### Get The Records With Popular Time Frames
After the visits get logged, you can retrieve the data by the following method:

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `withTotalVisitCount()` | `void` | get total visit count | `Post::withTotalVisitCount()->first()->visit_count_total` |
| `popularAllTime()` | `void` | get popular visits all time | `Post::popularAllTime()->get()` |
| `popularToday()` | `void` | get popular visits in the current day | `Post::popularToday()->get()` |
| `popularLastDays()` | int `$days` | get popular visits last given days | `Post::popularLastDays(10)->get()` |
| `popularThisWeek()` | `void` | get popular visits this week | `Post::popularThisWeek()->get()` |
| `popularLastWeek()` | `void` | get popular visits last week | `Post::popularLastWeek()->get()` |
| `popularThisMonth()` | `void` | get popular visits this month | `Post::popularThisMonth()->get()` |
| `popularLastMonth()` | `void` | get popular visits last month | `Post::popularLastMonth()->get()` |
| `popularThisYear()` | `void` | get popular visits this year | `Post::popularThisYear()->get()` |
| `popularLastYear()` | `void` | get popular visits last year | `Post::popularLastYear()->get()` |
| `popularBetween()` | Carbon `$from`, Carbon `$to` | get popular visits between custom two dates | `Post::popularBetween(Carbon::createFromDate(2019, 1, 9), Carbon::createFromDat(2022, 1, 3))->get();` |

## Visit Presenter
This package is coming with helpful decorate model properties, and it uses [Laravel Presenter](https://github.com/coderflexx/laravel-presenter) package under the hood.

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `ip()` | `void` | Get the associated IP from the model instance | `$post->visits->first()->present()->ip`|
| `user()` | `void` | Get the associated User from the model instance | `$post->visits->first()->present()->user->name`|

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Inspiration
- [Codecourse Laravel Model Popularity](https://codecourse.com/courses/laravel-model-popularity)

## Credits

- [Oussama Sid](https://github.com/ousid)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
