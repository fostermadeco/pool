<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Calls\Alias;
use FosterMadeCo\Pool\Calls\Group;
use FosterMadeCo\Pool\Calls\Identify;
use FosterMadeCo\Pool\Calls\Page;
use FosterMadeCo\Pool\Calls\Screen;
use FosterMadeCo\Pool\Calls\Track;
use Illuminate\Database\Eloquent\Model;

class Analytics
{
    /**
     * @param string|int $id
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function alias($id)
    {
        return Alias::call($id, auth()->user());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $group
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function group(Model $group)
    {
        return Group::call($group, auth()->user());
    }

    /**
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function identify()
    {
        return Identify::call(auth()->user());
    }

    /**
     * @param string|null $name
     * @param string|null $category
     * @param array|null $properties
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function page($name = null, $category = null, $properties = null)
    {
        return Page::call($name, $category, $properties, auth()->user());
    }

    /**
     * @param string $name
     * @param array|null $properties
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function screen($name, $properties = null)
    {
        return Screen::call($name, $properties, auth()->user());
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