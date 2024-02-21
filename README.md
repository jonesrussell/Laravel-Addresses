[![Latest Stable Version](https://poser.pugx.org/jonesrussell/laravel-addresses/v/stable)](https://packagist.org/packages/jonesrussell/laravel-addresses)
[![Total Downloads](https://poser.pugx.org/jonesrussell/laravel-addresses/downloads)](https://packagist.org/packages/jonesrussell/laravel-addresses)
[![License](https://poser.pugx.org/jonesrussell/laravel-addresses/license)](https://packagist.org/packages/jonesrussell/laravel-addresses)

# Laravel Addresses

Simple address and contact management for Laravel with automatical geocoding to add longitude and latitude.

## Installation

Require the package from your `composer.json` file

```php
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/jonesrussell/laravel-addresses"
    }
],
"require": {
    ...
	"jonesrussell/laravel-addresses": "dev-master"
}
```

and run `$ composer update`.

## Configuration & Migration

```bash
$ php artisan vendor:publish --provider="Jonesrussell\Addresses\AddressesServiceProvider"
```

This will publish the config file to `config/jonesrussell.php` and some migration files, that you'll have to run:

```bash
$ php artisan migrate
```

## Usage

First, add our `HasAddresses` trait to your model.

```php
<?php namespace App\Models;

use Jonesrussell\Addresses\Traits\HasAddresses;
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

use Jonesrussell\Addresses\Traits\HasContacts;
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

##### Relate Addresses with Contacts

Above all, `addresses` and `contacts` can be connected with an optional One To Many relationship. Like so you could assign multiple contacts to an address and retrieve them like so:

```php
$address = config('jonesrussell.addresses.model', \Jonesrussell\Addresses\Models\Address::class)::find(1);
$contacts = $address->contacts;

foreach ($contacts as $contact) {
    //
}
```

```php
$contact = config('jonesrussell.contacts.model', \Jonesrussell\Addresses\Models\Contact::class)::find(1)
                  ->contacts()
                  ->first();
```

```php
$contact = config('jonesrussell.contacts.model', \Jonesrussell\Addresses\Models\Contact::class)::find(1);

return $contact->address->getHtml();
```

##### Geocoding

The address model provides a method `geocode()` which will try to fetch longitude and latitude through the Google Maps API. Please make sure to add your key within the services config file at `services.google.maps.key`. If you set the option `jonesrussell.addresses.geocode` to `true`, the package will automatically fire the `geocode()` method whenever an addresses model is saved (precisely we hook into the `saving` event).

## Changelog

- [2021-02-02] **v1.0** The `geocode` configuration option now defaults to `false`.
- [2022-05-16] **v1.1** Updated dependencies to PHP 8 and Laravel 8/9 - for older versions please refer to v1.0.
- [2023-02-21] **v1.2** Laravel 10 support.
- [2023-09-21] **v1.3** Support custom models for addresses and contacts, thanks to @bfiessinger. The geocoding feature now requires a Google Maps key, see 'Geocoding' above. Also, @bfiessinger has added fallback support for flags, see pull request #40 for further info.
- [in-progress] **v1.4** Added additional contact fields to the addresses table, to allow for easier standalone usage (without the contacts model). This is intended to reduce the complexity of relationships and queries, that before were necessary e.g. to generate a shipping label from address and contact.

## License

Licensed under [MIT license](http://opensource.org/licenses/MIT).

## Author

**Handcrafted with love by [Alexander Manfred Poellmann](https://twitter.com/AMPoellmann) in Vienna &amp; Rome.**
