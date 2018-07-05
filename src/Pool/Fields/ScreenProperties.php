<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use Illuminate\Support\Str;

class ScreenProperties implements FieldInterface
{
    /**
     * @var array
     */
    public $properties = [];

    /**
     * @var array
     */
    public static $reservedProperties = [];

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
     * @return \FosterMadeCo\Pool\Fields\ScreenProperties
     * @throws \FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException
     */
    public static function create(array $array)
    {
        $properties = new self();

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
}
