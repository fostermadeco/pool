<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Calls\Identify;
use FosterMadeCo\Pool\Calls\Track;

class Analytics
{
    /**
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function identify()
    {
        return Identify::call(auth()->user());
    }

    /**
     * @param string $event
     * @param array|null $properties
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function track($event, $properties = null)
    {
        return Track::call($event, $properties, auth()->user());
    }
}