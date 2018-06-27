<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Calls\Identify;
use FosterMadeCo\Pool\Calls\Page;
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

    /**
     * @param string|null $name
     * @param string|null $category
     * @param array|null $properties
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function page($name = null, $category = null, $properties = null)
    {
        Page::call($name, $category, $properties, auth()->user());
    }
}