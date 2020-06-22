## Installation

```sh
composer require koutech/class-base-filter
```

__Class Base Filter__

- Go to the app folder and create a folder name called __Filter__
- Create Some class e.g UserFilter.php


## Inside Filter Class 

__all you have to do is just extend the `Koutech\TopLayerForSpatieQueryBuilder\Filter`__
__contain at least two methods `fields` and `model` inside class__

```php
<?php 

namespace App\Filter;

use Koutech\TopLayerForSpatieQueryBuilder\Filter;

use App\User;


class UserFilter extends Filter
{

    public function model() 
    {
        return User::class;
    }
    
    public function fields() 
    {
        return ['name'];
    }


}
```


## Usage


```php
<?php

$users = UserFilter::filter()->get();

```

## Set Eager Loading 

__contain method called include inside class__
__example if you want to contain post that belongs to the user all you have to do is...__

```php
<?php 

public function eagerLoading() 
{
    return ['post'];
}
```

## Set Eager Loading From Url

__contain method called include inside class__
__example if you want to contain post that belongs to the user all you have to do is...__

```php
<?php 

public function includes() 
{
    return ['post'];
}
```

