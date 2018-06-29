# Screen

## Making `screen` calls in the application

Use `Analytics::screen(string $name, array $properties)` to log a screen the
authenticated user has viewed. Where `$name` is the name of the screen being
viewed and `$properties` is an array of data points to collect about the screen.

To make a `screen` call for another user, use `FosterMadeCo\Pool\Screen::call()`
and specify the user model, for example:

```php
$user = \App\User::find(123);

$name = "The Magician's Nephew";
$properties = [
    "campaign" => "A",
    "ads" => [
        "168c9616-73e0-427f-9637-22cd1fb3dea7",
        "36889411-d78e-4518-8d28-4c5dba759095",
    ],
];

FosterMadeCo\Pool\Screen::call($event, $properties, $user);
```

## Method Descriptions

```php
Analytics::screen(string $name [, array $properties ] )
```

```php
FosterMadeCo\Pool\Screen::call(string $name [, array $properties [, \Illuminate\Contracts\Auth\Authenticatable $model ]] )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.