<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Fields\Context;
use FosterMadeCo\Pool\Fields\UserId;
use Illuminate\Contracts\Auth\Authenticatable;

class BaseCall
{
    /**
     * Application configuration for Segment
     *
     * @var array
     */
    protected $config;

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

    /**
     * The the destinations the message will be sent to
     *
     * @var array
     */
    protected $integrations;

    public function __construct()
    {
        $this->config = config('segment');
        $this->setContext();
        $this->setIntegrations($this->config['integrations']);
    }

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

    /**
     * @param array $integrations
     */
    protected function setIntegrations(array $integrations)
    {
        $this->integrations = $integrations;
    }
}