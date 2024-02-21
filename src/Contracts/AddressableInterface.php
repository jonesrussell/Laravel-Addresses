<?php

namespace Jonesrussell\Addresses\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interface AddressableInterface
 * @package Jonesrussell\Addresses\Contracts
 */
interface AddressableInterface
{
    public function addresses(): MorphMany;
}