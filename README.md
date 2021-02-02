[![Latest Stable Version](https://poser.pugx.org/lecturize/laravel-addresses/v/stable)](https://packagist.org/packages/lecturize/laravel-addresses)
[![Total Downloads](https://poser.pugx.org/lecturize/laravel-addresses/downloads)](https://packagist.org/packages/lecturize/laravel-addresses)
[![License](https://poser.pugx.org/lecturize/laravel-addresses/license)](https://packagist.org/packages/lecturize/laravel-addresses)

# Laravel Addresses

Simple address and contact management for Laravel 5 with automatical geocoding to add longitude and latitude. Uses the famous [Countries](https://github.com/webpatser/laravel-countries) package by Webpatser.

## Installation

Require the package from your `composer.json` file

```php
"require": {
	"lecturize/laravel-addresses": "^1.0"
}
```

and run `$ composer update` or both in one with `$ composer require lecturize/laravel-addresses`.

## Configuration & Migration

```bash
$ php artisan vendor:publish --provider="Webpatser\Countries\CountriesServiceProvider"
$ php artisan vendor:publish --provider="Lecturize\Addresses\AddressesServiceProvider"
```

This will create a `config/countries.php`, a `config/lecturize.php` and the migration files, that you'll have to run like so:

```bash
$ php artisan countries:migration
$ php artisan migrate
```

For migrations to be properly published ensure that you have added the directory `database/migrations` to the classmap in your projects `composer.json`.

Check out [Webpatser\Countries](https://github.com/webpatser/laravel-countries) readme to see how to seed their countries data to your database.

## Usage

First, add our `HasAddresses` trait to your model.
        
```php
<?php namespace App\Models;

use Lecturize\Addresses\Traits\HasAddresses;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAddresses;

    // ...
}
?>
```

##### Add an Address to a Model
```php
$post = Post::find(1);
$post->addAddress([
    'street'     => '123 Example Drive',
    'city'       => 'Vienna',
    'post_code'  => '1110',
    'country'    => 'AT', // ISO-3166-2 or ISO-3166-3 country code
    'is_primary' => true, // optional flag
]);
```

Alternativly you could do...

```php
$address = [
    'street'     => '123 Example Drive',
    'city'       => 'Vienna',
    'post_code'  => '1110',
    'country'    => 'AT', // ISO-3166-2 or ISO-3166-3 country code
    'is_primary' => true, // optional flag
];
$post->addAddress($address);
```

Available attributes are `street`, `street_extra`, `city`, `post_code`, `state`, `country`, `state`, `notes` (for internal use). You can also use custom flags like `is_primary`, `is_billing` & `is_shipping`. Optionally you could also pass `lng` and `lat`, in case you deactivated the included geocoding functionality and want to add them yourself.

##### Check if Model has Addresses
```php
if ($post->hasAddresses()) {
    // Do something
}
```

##### Get all Addresses for a Model
```php
$addresses = $post->addresses()->get();
```

##### Get primary/billing/shipping Addresses
```php
$address = $post->getPrimaryAddress();
$address = $post->getBillingAddress();
$address = $post->getShippingAddress();
```

##### Update an Address for a Model
```php
$address = $post->addresses()->first(); // fetch the address

$post->updateAddress($address, $new_attributes);
```

##### Delete an Address from a Model
```php
$address = $post->addresses()->first(); // fetch the address

$post->deleteAddress($address); // delete by passing it as argument
```

##### Delete all Addresses from a Model
```php
$post->flushAddresses();
```

## Contacts

First, add our `HasContacts` trait to your model.

```php
<?php namespace App\Models;

use Lecturize\Addresses\Traits\HasContacts;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasContacts;

    // ...
}
?>
```

##### Add a Contact to a Model
```php
$post = Team::find(1);
$post->addContact([
    'first_name' => 'Alex',
    'website'    => 'https://twitter.com/AMPoellmann',
    'is_primary' => true, // optional flag
]);
```

## Changelog

- [2021-02-02] **v1.0** The `geocode` configuration option now defaults to `false`.
- [2021-02-02] **v1.0** The custom `flags` feature might be removed in future releases (in favour of the `properties` attribute).

## License

Licensed under [MIT license](http://opensource.org/licenses/MIT).

## Author

**Handcrafted with love by [Alexander Manfred Poellmann](https://twitter.com/AMPoellmann) in Vienna &amp; Rome.**