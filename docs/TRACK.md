# Track

## Making `track` calls in the application

Use `Analytics::track(string $event, array $properties)` to track an event on the
authenticated user. Where `$event` is the name of the thing being tracked and
`$properties` is an array of data points to collect about the event.

To make a `track` call for another user, use `FosterMadeCo\Pool\Track::call()` and
specify the user model, for example:

```php
$user = \App\User::find(123);

$event = "Book Purchased";
$properties = [
    "item" => "The Lion, The Witch, & the Wardrobe",
    "revenue" => 19.95,
    "currency" => "USD",
];

FosterMadeCo\Pool\Track::call($event, $properties, $user);
```

## Method Descriptions

```php
Analytics::track(string $event [, array $properties ] )
```

```php
FosterMadeCo\Pool\Track::call(string $event [, array $properties [, \Illuminate\Contracts\Auth\Authenticatable $model ]] )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.