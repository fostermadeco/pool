A Segment package for Laravel.

The goal of this package is to make it easier to use Segmento within a Laravel package.
It formats the data as needed and uses `segmentio/analytics-php` to make the API calls.

## Calls

1. [Identify](docs/IDENTIFY.md)
2. [Track](docs/TRACK.md)
3. [Page](docs/PAGE.md)
4. [Sreen](docs/SCREEN.md)
5. [Group](docs/GROUP.md)
6. [Alias](docs/ALIAS.md)


## Installation

Currently Laravel 5.6 is the only version supported.

Add this to the project's repositories array in `composer.json` if an OAuth token is being used:

```
{
    "name": "laravel/laravel",
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:fostermadeco/pool.git"
        }
    ],
    ...
}
```

Or add this if not:

```
{
    "name": "laravel/laravel",
    ...
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "fostermadeco/pool",
                "version": "0.0.4",
                "source": {
                    "url": "git@github.com:fostermadeco/pool.git",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
    ]
    ...
}
```

Require the package:

```
composer require fostermadeco/pool
```