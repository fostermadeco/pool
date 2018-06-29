# Group

1. [Group Traits](#1-group-traits)
2. [Making `group` calls in the application](#2-making-page-calls-in-the-application)
3. [Method Descriptions](#3-method-descriptions)

## 1. Group Traits

Add the list of traits that will be sent to Segment whenever the `group` call
should be made to the Eloquent model.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The Group data that will be sent to Segment
     * 
     * @var array
     */
    public $traits = [
        "name",
        "email",
        "employees",
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

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $traits = [
        "name",
        "email",
        "employees",
        "address" => "segment_address",
    ];

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
        "groupId" => ...
        "traits" => [
            "name" => "Lumen",
            "email" => lumen@laravel.com,
            "employees" => 2,
            "address" => [
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
integrity before it is sent to Segment, Exceptions will be thrown if incorrect data
is sent.

## 2. Making `group` calls in the application

Use `\Analytics::group($group)` to assign the authenticated user to a group
where `$group` is an Eloquent model.

To make a `group` call for another user, use `\FosterMadeCo\Pool\Group::call()` and
specify the model, for example:

```php
$user = \App\User::find(123);

$group = \App\Company::find(456);

\FosterMadeCo\Pool\Page::call($group, $user)
```

## 3. Method Descriptions

```php
\Analytics::group(\Illuminate\Database\Eloquent\Model $group )
```

```php
\FosterMadeCo\Pool\Group::call(\Illuminate\Database\Eloquent\Model $group [, \Illuminate\Contracts\Auth\Authenticatable $model ] )
```

Both of these calls return **TRUE** if the call was successful or **FALSE** if not.