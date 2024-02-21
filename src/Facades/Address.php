<?php

namespace Jonesrussell\Addresses\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Address
 * @package Jonesrussell\Addresses\Facades
 */
class Address extends Facade
{
    /** @inheritdoc */
    protected static function getFacadeAccessor(): string
    {
        return 'address';
    }
}