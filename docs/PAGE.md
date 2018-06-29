# Page

## Making `page` calls in the application

Use `\Analytics::page($name, $category, $properties)`
to track an event on the authenticated user. Where `$name` is the name of the page, `$category` is a
categorization of the page, and `$properties` is an array of data points to collect about the event.
None of these parameters are required.

To make a `page` call for another user, use `\FosterMadeCo\Pool\Page::call()` and
specify the model, for example:

```php
$user = \App\User::find(123);

$name = "The Magician's Nephew";
$category = "Series";
$properties = [
    "title" => "The Chronicles of Narnia: The Magician's Nephew - Book 6",
    "keywords" => [
        "series",
        "Narnia",
        "C.S. Lewis",
    ],
];

\FosterMadeCo\Pool\Page::call($name, $category, $properties, $user)
```

## Method Descriptions

```php
\Analytics::page([string $name = null [, string $category = null [, array $properties = null ]]] )
```

```php
\FosterMadeCo\Pool\Page::call([string $name = null [, string $category = null [, array $properties = null [, \Illuminate\Contracts\Auth\Authenticatable $model ]]]] )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.