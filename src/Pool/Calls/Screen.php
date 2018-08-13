<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Fields\ScreenProperties;
use Illuminate\Contracts\Auth\Authenticatable;
use Segment;

class Screen extends BaseCall
{
    /**
     * The name of the screen being viewed
     *
     * @var string
     */
    public $name;

    /**
     * Properties of the screen
     *
     * @var \FosterMadeCo\Pool\Fields\ScreenProperties
     */
    public $properties;

    /**
     * Track constructor.
     *
     * @param string $name
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct($name)
    {
        parent::__construct();

        $this->setName($name);
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        if ($this->name) {
            $message['name'] = $this->name;
        }

        if ($this->properties) {
            $message['properties'] = $this->properties->toArray();
        }

        if ($this->context) {
            $message['context'] = $this->context->toArray();
        }

        if ($this->integrations) {
            $message['integrations'] = $this->integrations;
        }

        return $message;
    }

    /**
     * @return bool
     */
    public function sendRequest()
    {
        return Segment::screen($this->getMessage());
    }

    /**
     * @param string $name
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new FieldNotAStringException('name');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @param array $properties
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setProperties($properties)
    {
        $this->properties = ScreenProperties::create($properties);

        return $this;
    }

    /**
     * @param string $name
     * @param array|null $properties
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call($name, $properties = null, Authenticatable $model = null)
    {
        return self::make($name, $properties, $model)->sendRequest();
    }

    /**
     * @param string $name
     * @param array|null $properties
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @return \FosterMadeCo\Pool\Calls\Screen
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function make($name, $properties = null, Authenticatable $model = null)
    {
        $screen = new self($name);
        $screen->setIdentificationKey($model);

        if (!is_null($properties)) {
            $screen->setProperties($properties);

            $screen->properties->validate(true, $screen->validateFields);
        }

        return $screen;
    }
}