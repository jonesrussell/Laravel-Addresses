<?php

namespace Jonesrussell\Addresses\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

use Jonesrussell\Addresses\Models\Address;
use Jonesrussell\Addresses\Models\Contact;

/**
 * Class OwnsAddresses
 * @package Jonesrussell\Addresses\Traits
 * @property-read Collection|Address[]  $addresses
 * @property-read Collection|Contact[]  $contacts
 */
trait OwnsAddresses
{
    public function addresses(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(config('jonesrussell.addresses.model', Address::class));
    }

    public function contacts(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(config('jonesrussell.contacts.model', Contact::class));
    }

    /** @return Address[]|Collection */
    public function getBillingAddresses(): Collection|array
    {
        return $this->addresses()
                    ->billing()
                    ->get();
    }

    /** @return Address[]|Collection */
    public function getShippingAddresses(): Collection|array
    {
        return $this->addresses()
                    ->shipping()
                    ->get();
    }
}
