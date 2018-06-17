<?php

namespace FosterMadeCo\Pool\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool identify()
 *
 * @see \FosterMadeCo\Pool\Analytics
 */
class Analytics extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'analytics';
    }
}
