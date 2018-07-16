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
    public $config;

    /**
     * The context of the call
     *
     * @var \FosterMadeCo\Pool\Fields\Context
     */
    public $context;

    /**
     * How Segment will identify the user
     *
     * @var \FosterMadeCo\Pool\Fields\UserId
     */
    public $identificationKey;

    /**
     * The the destinations the message will be sent to
     *
     * @var array
     */
    public $integrations;

    /**
     * Validate the fields
     *
     * @var boolean
     */
    public $validateFields;

    /**
     * BaseCall constructor.
     */
    public function __construct()
    {
        $this->config = config('segment');

        $this->validateFields = $this->config['validate'];
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
    public function setIdentificationKey(Authenticatable $model = null)
    {
        $this->identificationKey = new UserId($model);
    }

    /**
     * @param array $integrations
     */
    public function setIntegrations(array $integrations)
    {
        $this->integrations = $integrations;
    }
}