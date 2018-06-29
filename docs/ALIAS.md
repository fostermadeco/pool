# Alias

## Making `alias` calls in the application

Use `Analytics::alias(string|int $previousId)` to associate the authenticated user
with a new id. Where `$previousId` is the previous id of the user.

To make a `alias` call for another user, use `FosterMadeCo\Pool\Alias::call()`
and specify the user model, for example:

```php
$user = \App\User::find(123);

$previousId = session('segment.anonymousId');

FosterMadeCo\Pool\Screen::call($previousId, $user);
```

## Method Descriptions

```php
Analytics::alias(string|int $previousId, \Illuminate\Contracts\Auth\Authenticatable $userId )
```

```php
FosterMadeCo\Pool\Alias::call(string|int $previousId, \Illuminate\Contracts\Auth\Authenticatable $userId )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.