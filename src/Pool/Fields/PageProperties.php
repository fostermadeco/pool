<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\FieldNotAnArrayException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

class PageProperties implements Field
{
    /**
     * @var array
     */
    public $properties = [];

    /**
     * @var array
     */
    public static $reservedProperties = [
        'keywords', 'path', 'referrer', 'search', 'title', 'url',
    ];

    /**
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validator;

    /**
     * PageProperties constructor.
     *
     * @param \Illuminate\Contracts\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array(Str::snake($name), $this->properties)) {
            return $this->properties[Str::snake($name)];
        }

        return $this->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($this->isReservedProperty($name)) {
            $method = 'set' . Str::studly($name);

            $this->{$method}($value);
        } else {
            $this->properties[$name] = $value;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $properties = [];

        foreach ($this->properties as $attribute => $value) {
            if (is_object($value)) {
                $properties[$attribute] = $value->toArray();
            } else {
                $properties[$attribute] = $value;
            }
        }

        return $properties;
    }

    /**
     * @param array $array
     * @return \FosterMadeCo\Pool\Fields\PageProperties
     * @throws \FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException
     */
    public static function create(array $array)
    {
        $properties = app()->make(self::class);

        foreach ($array as $attribute => $value) {
            if (is_int($attribute)) {
                // The value needs to be a string
                if (!is_string($value)) {
                    throw new ArrayKeyRequiredException('properties');
                }

                $properties->$value = $value;
            } else {
                $properties->$attribute = $value;
            }
        }

        return $properties;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isReservedProperty($name)
    {
        return in_array(Str::snake($name), self::$reservedProperties);
    }

    /**
     * @param $value
     * @throws FieldNotAnArrayException
     */
    protected function setKeywords($value)
    {
        if (!is_array($value)) {
            throw new FieldNotAnArrayException('keywords');
        }
        array_walk($value, function ($item, $key) {
            if (!is_string($item)) {
                throw new FieldInvalidException('The keywords field needs to be an array of strings.');
            }
        });

        $this->properties['keywords'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setPath($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('path');
        }

        $this->properties['path'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setReferrer($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('referrer');
        }

        $this->properties['referrer'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setSearch($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('search');
        }

        $this->properties['search'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setTitle($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('title');
        }

        $this->properties['title'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setUrl($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('url');
        }

        $this->properties['url'] = $value;
    }
}