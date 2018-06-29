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
    protected $name;

    /**
     * Properties of the screen
     *
     * @var array
     */
    protected $properties;

    /**
     * Track constructor.
     *
     * @param string $name
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct($name)
    {
        $this->setName($name);
        $this->setContext();
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
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new FieldNotAStringException('name');
        }

        $this->name = $name;
    }

    /**
     * @param array $properties
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setProperties($properties)
    {
        $this->properties = ScreenProperties::create($properties);
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
        $track = new self($name);
        $track->setIdentificationKey($model);

        if (!is_null($properties)) {
            $track->setProperties($properties);
        }

        return $track->sendRequest();
    }
}