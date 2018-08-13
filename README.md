A Segment package for Laravel.

The goal of this package is to make it easier to use Segmento within a Laravel package.
It formats the data as needed and uses `segmentio/analytics-php` to make the API calls.

## Installation

Currently Laravel 5.6 is the only version supported.

Require the package:

```
composer require fostermadeco/pool
```

Publish the config:

```
php artisan vendor:publish
```

Add default destinations to the integrations array in the segment config file, for example:

```php
    'integrations' => [
        'All' => false,
        'Google Analytics' => true,
        'Optimizely' => true,
    ],
```

Add `SEGMENT_WRITE_KEY` to your `.env` file and assign it the value of the write key Segment
provides for your source:

```
SEGMENT_WRITE_KEY=
```

Further setup is detailed in the documentation below.

## Calls

1. [Identify](docs/IDENTIFY.md)
2. [Track](docs/TRACK.md)
3. [Page](docs/PAGE.md)
4. [Sreen](docs/SCREEN.md)
5. [Group](docs/GROUP.md)
6. [Alias](docs/ALIAS.md)