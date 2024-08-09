<?php

namespace Darko\FilamentContentToolkits\Facades;

use Darko\FilamentContentToolkits\Services\Contracts\Site as SiteContract;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Darko\FilamentContentToolkits\FilamentContentToolkits
 */
class Site extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SiteContract::class;
    }
}
