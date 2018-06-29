# Identify

1. [Identifying Authenticated Users](#1-identifying-authenticated-users)
2. [Identifying Non-Anonymous Users](#2-identifying-non-anonymous-users)
3. [Making `identify` Calls In the Application](#3-making-identify-calls-in-the-application)
4. [Method Descriptions](#4-method-descriptions)

## 1. Identifying Authenticated Users

### Identify Traits

Add the list of traits that will be sent to Segment whenever the `identity` call
should be made to the Authenticatable model. The application's Authenticatable
model is likely the `App\User`, but any model that implements the
`Illuminate\Contracts\Auth\Authenticatable` contract can be used. 

```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The User data that will be sent to Segment
     * 
     * @var array
     */
    public $traits = [
        "first_name",
        "last_name",
        "email",
        "dob",
    ];
}
```

Each item in the `$traits` array will be treated as if it were an attribute of
the model. In the message to Segment, the attribute's name and value will be used
as the key and value, respectively. To use a different key in the Segment message,
add a key to the value in the `$traits` model. For example:

```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    CONST TYPE = "Administrator";

    public $traits = [
        "first_name",
        "last_name",
        "user_type" => "type",
        "address" => "segment_address",
    ];

    public function getTypeAttribute()
    {
        return self::TYPE;
    }

    public function getAddressAttribute()
    {
        return [
            "street" => $this->attributes["address"],
            "city" => $this->attributes["city"],
            "state" => $this->attributes["state"],
            "postal_code" => $this->attributes["zip"],
        ];
    }
}

```

Will yield:

```php
    [
        "userId" => ...
        "traits" => [
            "first_name" => "Taylor",
            "last_name" => "Otwell",
            "user_type" => "Administrator",
            "address => [
                "street" => "200 Laravel Ln",
                "city" => "Cair Paravel",
                "state" => "Narnia",
                "postal_code" => null,
            ]
        ],
        ...
    ]
```


Segment has certain traits with reserved meanings. In an attempt to enforce data
integrity before it is sent to Segment, Exceptions will be thrown if incorrect
data is sent.

### Idenfify After Create or Update

To make an `identify` call whenever a user is created or updated, add the
`\FosterMadeCo\Pool\Traits\Idenfity` trait to your User model. 

```php
<?php

namespace App;

use FosterMadeCo\Pool\Traits\Identify;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Identify;
    ...
}
```

If you don't always want to make the `identify` call after a user is created or
updated, you can add the public `canIdentify()` method to the model and have it
return **TRUE** when the call can be made.

### Idenfify On Login

To make an `identify` call whenever a user logs in, add
`\FosterMadeCo\Pool\Identify::call($user)` to the `authenticated()` method
on the Controller that handles the application's login:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use FosterMadeCo\Pool\Identify;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Identify::call($user);
    }
}
```

### Current Limitations

If any of the Authenticatable model's $traits reference another model, if that
model is updated, then `identify` won't be called automatically. For example,
if a User's address is stored in the Address relation and the Address relation
is updated, then a `identify` call will need to be added.

## 2. Identifying Non-Anonymous Users

The easiest way to do this is to use `\FosterMadeCo\Pool\Identify::call()` like so:

```php
\FosterMadeCo\Pool\Identify::call(null, $traits = [ ... ]); // $traits can be null
```

An anonymous user with a UUID will be created.

## 3. Making `identify` Calls In the Application

If you wish to perform an `identify` call on the authenticated user, you
can use `\Analytics::identify()`.

To identify a specific user, use `\FosterMadeCo\Pool\Identify::call()` and
specify the model, e.g.,:

```$php
$user = \App\User::find(123);

\FosterMadeCo\Pool\Identify::call($user);
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.

## 4. Method Descriptions


```php
\Analytics::identify()
```

```php
\FosterMadeCo\Pool\Identify::call([ \Illuminate\Contracts\Auth\Authenticatable $model [, array $traits ]] )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.