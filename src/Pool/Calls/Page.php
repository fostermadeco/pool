<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Fields\PageProperties;
use Illuminate\Contracts\Auth\Authenticatable;
use Segment;

class Page extends BaseCall
{
    /**
     * The category of the page the user sees
     *
     * @var string
     */
    public $category;

    /**
     * The name of the page the user sees
     *
     * @var string
     */
    public $name;

    /**
     * Properties of the page
     *
     * @var \FosterMadeCo\Pool\Fields\PageProperties
     */
    public $properties;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        if ($this->category) {
            $message['category'] = $this->category;
        }

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
        return Segment::page($this->getMessage());
    }

    /**
     * @param string $category
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setCategory($category)
    {
        if (!is_string($category) && !is_null($category)) {
            throw new FieldNotAStringException('category');
        }

        $this->category = $category;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setName($name)
    {
        if (!is_string($name) && !is_null($name)) {
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
        $this->properties = PageProperties::create($properties);

        return $this;
    }

    /**
     * @param string|null $name
     * @param string|null $category
     * @param array|null $properties
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call($name = null, $category = null, $properties = null, Authenticatable $model = null)
    {
        $page = new self();
        $page->setIdentificationKey($model);

        if (!is_null($name)) {
            $page->setName($name);
        }

        if (!is_null($category)) {
            $page->setCategory($category);
        }

        if (!is_null($category)) {
            $page->setProperties($properties);

            $page->properties->validate(true, $page->validateFields);
        }

        return $page->sendRequest();
    }
}