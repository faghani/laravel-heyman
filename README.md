# Laravel Hey Man

## A package to help you write expressive code in a functional manner

![image](https://user-images.githubusercontent.com/6961695/43285148-4d86673e-9133-11e8-9415-2df017906762.png)

## And it works !!!

<a href="https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/laravel-heyman.svg?style=round-square" alt="Quality Score"></img></a>
[![code coverage](https://codecov.io/gh/imanghafoori1/laravel-heyman/branch/master/graph/badge.svg)](https://codecov.io/gh/imanghafoori1/laravel-heyman)
[![Maintainability](https://api.codeclimate.com/v1/badges/9d6be7b057103cb14410/maintainability)](https://codeclimate.com/github/imanghafoori1/laravel-heyman/maintainability)
[![Build Status](https://travis-ci.org/imanghafoori1/laravel-heyman.svg?branch=master)](https://travis-ci.org/imanghafoori1/laravel-heyman)
[![StyleCI](https://github.styleci.io/repos/139709518/shield?branch=master)](https://github.styleci.io/repos/139709518)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-heyman/v/stable)](https://packagist.org/packages/imanghafoori/laravel-heyman)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=round-square)](LICENSE.md)



## :ribbon::ribbon::ribbon: HeyMan : "_cleaner code_" :heavy_plus_sign: "_easy authorization_" :ribbon::ribbon::ribbon:

### Built with :heart: for every smart laravel developer


## Installation

```

composer require imanghafoori/laravel-heyman

```

### Requirements:

```
PHP > v7.0
Laravel > v5.4
```


Imagine your boss comes to you and says :

> Hey man,
> When you go to login form, You should be guest,
> Otherwise you must get redirected to '/panel',
> Write the code for me, just now... But KEEP IN MIND you are not allowed to touch the current code. it is very sensitive and we do not want you to tamper with it. You may break it.



And you write code like this in a Service Provider `boot` method to implement what your boss wanted.


![image](https://user-images.githubusercontent.com/6961695/43285559-8c09a1e6-9134-11e8-841b-2dc933456082.png)


### That is what this package does for you + a lot more...


### Structural Benefits:

This way you can fully decouple authorization and a lot of guarding code from the rest of your application code and put it in an other place. So your Controllers and Routes become less crowded. and you will have a central place where you limit the access of users to your application.


#### Should You Remember and Type in All The Methods? 
> IDE `Auto-completion` is fully supported.

![untitled](https://user-images.githubusercontent.com/6961695/43330799-7d02cc54-91d9-11e8-845b-946077033ec6.png)

#### Where do I put these codes ?
> You can put these codes in `AuthServiceProvider.php` (or any other service provider) `boot` method to take effect.


![image](https://user-images.githubusercontent.com/6961695/43330086-66d0b9a2-91d7-11e8-84fb-fa4ff90821a3.png)



## Watching Urls

```php
HeyMan::whenYouVisitUrl(['/welcome', '/home'])->...   // you can pass an Array
HeyMan::whenYouVisitUrl( '/welcome', '/home' )->...   // variable number of args
HeyMan::whenYouVisitUrl('/admin/articles/*')->...     // or match by wildcard
```


## Watching Route Names

```php
HeyMan::whenYouVisitRoute('welcome.name')->...
HeyMan::whenYouVisitRoute('welcome.*')->...                 // or match by wildcard
```


## Watching Controller Actions

```php
HeyMan::whenYouCallAction('HomeController@index')->...
HeyMan::whenYouCallAction('HomeController@*')->...          // or match by wildcard
```

## Watching Blade files
```php 
 HeyMan::whenYouMakeView('article.editForm')->...     // also accepts an array
 HeyMan::whenYouMakeView('article.*')->...            // You can watch a group of views
 ```
 
 ## Watching Custom Events
```php
HeyMan::whenEventHappens('myEvent')->...
```

## Watching Eloquent Model Events
```php
HeyMan::whenYouSave(\App\User::class)->...
HeyMan::whenYouFetch(\App\User::class)->...
HeyMan::whenYouCreate(\App\User::class)->...
HeyMan::whenYouUpdate(\App\User::class)->...
HeyMan::whenYouDelete(\App\User::class)->...
```
 
 #### Note that the saving model is passed to the Gate of callback in the next chain call. so for example you can check the ID of the model which is saving.
 
*In case the gate returns `false` an `AuthorizationException` will be thrown.
*(If it is not the thing you want, do not worry you can customize the action very easily, we will discuss shortly.)


This way gate is checked after `event('myEvent')` is executed any where in our app




## What can be checked:

### 1 - Gates

```php
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('hasRole', 'param1')->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('SomeClass@someMethod', 'param1')->otherwise()->...;
```

Passing a Closure as a Gate:

```php
$gate = function($user, $role){
    /// some logic
    return true;
}
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow($gate, 'editor')->otherwise()->...;
```

### 2 - Authentication stuff:
```php
HeyMan::whenYouVisitUrl('/home')->  youShouldBeGuest()    ->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->  youShouldBeLoggedIn() ->otherwise()->...;
```

### 3 - Checking A `Closure` or `Method` or `Value`:
```php
HeyMan::whenYouVisitUrl('home')->thisMethodShouldAllow('someClass@someMethod', ['param1'])->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisClosureShouldAllow(ّ function($a) { ... }, ['param1'])  ->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisValueShouldAllow(ّ $someValue )->otherwise()->...;
```

### Other
You can also use one of these:
```
HeyMan::whenYouVisitUrl('home')->youShouldAlways()-> ...
HeyMan::whenYouVisitUrl('home')->sessionShouldHave('key1')->...

```

--------------------


## Reactions:

### 1 - Deny Access
```php
HeyMan::whenSaving(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
```
An `AuthorizationException` will be thrown if needed


### 2 - Redirect
```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->to(...)     ->with([...]);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->route(...)  ->withErrors(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->action(...) ->withInput(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->intended(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->guest(...);
```

### 3- Throw Exception:
```php
$msg = 'My Message';

HeyMan::whenYouVisitUrl('/login')
    ->youShouldBeGuest()
    ->otherwise()
    ->throwNew(AuthorizationException::class, $msg);
```

### 4- Abort:
```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->abort(...);
```

### 5- Send Response:
Calling these functions generate exact same response as calling them on the `response()` helper function:
`return response()->json(...);`

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->view(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->jsonp(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->make(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->download(...);
```

## Advanced Usage:

You may want to call some method or fire an event right before you send the response back.
You can do so by `afterCalling()` and `afterFiringEvent()` methods.

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterFiringEvent('explode')->response()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterCalling('someclass@method1')->response()->json(...);
```


--------------------

### :raising_hand: Contributing 
If you find an issue, or have a better way to do something, feel free to open an issue or a pull request.
If you use laravel-widgetize in your open source project, create a pull request to provide it's url as a sample application in the README.md file. 


### :exclamation: Security
If you discover any security related issues, please email imanghafoori1@gmail.com instead of using the issue tracker.


### :star: Your Stars Make Us Do More :star:
As always if you found this package useful and you want to encourage us to maintain and work on it. Just press the star button to declare your willing.
