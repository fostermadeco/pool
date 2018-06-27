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
    protected $category;

    /**
     * The name of the page the user sees
     *
     * @var string
     */
    protected $name;

    /**
     * Properties of the page
     *
     * @var array
     */
    protected $properties;

    /**
     * Page constructor.
     *
     * @param string|null $name
     * @param string|null $category
     * @param array|null $properties
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct($name = null, $category = null, $properties = null)
    {
        $this->setName($name);
        $this->setCategory($category);
        $this->setProperties($properties);
        $this->setContext();
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
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setCategory($category)
    {
        if (!is_string($category) && !is_null($category)) {
            throw new FieldNotAStringException('category');
        }

        $this->category = $category;
    }

    /**
     * @param string $name
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setName($name)
    {
        if (!is_string($name) && !is_null($name)) {
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
        $this->properties = is_null($properties) ? $properties : PageProperties::create($properties);
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
        $page = new self($name, $category, $properties);
        $page->setIdentificationKey($model);

        return $page->sendRequest();
    }
}