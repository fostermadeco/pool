<?php

namespace FosterMadeCo\Pool;

use FosterMadeCo\Pool\Calls\Identify;

class Analytics
{
    /**
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function identify()
    {
        Identify::call(auth()->user());
    }
}