<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Fields\TrackProperties;
use Illuminate\Contracts\Auth\Authenticatable;
use Segment;

class Track extends BaseCall
{
    /**
     * The name of the event being tracked
     *
     * @var string
     */
    public $event;

    /**
     * Properties of the event
     *
     * @var \FosterMadeCo\Pool\Fields\TrackProperties
     */
    public $properties;

    /**
     * Track constructor.
     *
     * @param string $event
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct($event)
    {
        parent::__construct();

        $this->setEvent($event);
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        if ($this->event) {
            $message['event'] = $this->event;
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
        return Segment::track($this->getMessage());
    }

    /**
     * @param string $event
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setEvent($event)
    {
        if (!is_string($event)) {
            throw new FieldNotAStringException('event');
        }

        $this->event = $event;

        return $this;
    }

    /**
     * @param array $properties
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setProperties($properties)
    {
        $this->properties = TrackProperties::create($properties);

        return $this;
    }

    /**
     * @param string $event
     * @param array|null $properties
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call($event, $properties = null, Authenticatable $model = null)
    {
        return self::make($event, $properties, $model)->sendRequest();
    }

    /**
     * @param string $event
     * @param array|null $properties
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @return \FosterMadeCo\Pool\Calls\Track
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function make($event, $properties = null, Authenticatable $model = null)
    {
        $track = new self($event);
        $track->setIdentificationKey($model);

        if (!is_null($properties)) {
            $track->setProperties($properties);

            $track->properties->validate(true, $track->validateFields);
        }

        return $track;
    }
}