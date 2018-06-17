<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Fields\Context;
use FosterMadeCo\Pool\Fields\UserId;
use Illuminate\Contracts\Auth\Authenticatable;

class BaseCall
{
    /**
     * The context of the call
     *
     * @var \FosterMadeCo\Pool\Fields\Context
     */
    protected $context;

    /**
     * How Segment will identify the user
     *
     * @var \FosterMadeCo\Pool\Fields\UserId
     */
    protected $identificationKey;

    // TODO
    public function setContext()
    {
        $this->context = new Context();
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     */
    protected function setIdentificationKey(Authenticatable $model = null)
    {
        $this->identificationKey = new UserId($model);
    }
}