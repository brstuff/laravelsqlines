<?php

namespace brstuff\LaravelSqlines\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSqlines extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelsqlines';
    }
}
