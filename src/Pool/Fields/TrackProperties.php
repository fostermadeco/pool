<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotAFloatOrIntegerException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use Illuminate\Support\Str;

class TrackProperties implements Field
{
    /**
     * @var array
     */
    public $properties = [];

    /**
     * @var array
     */
    public static $reservedProperties = [
        'currency', 'revenue', 'value',
    ];

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
     * @return \FosterMadeCo\Pool\Fields\TrackProperties
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
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    protected function setCurrency($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('currency');
        } elseif (!preg_match('/^[A-Z]{3,4}$/', $value)) {
            throw new FieldInvalidException('The currency field needs to be in ISO 4217.');
        }

        $this->properties['currency'] = $value;
    }

    /**
     * @param float|int $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAFloatOrIntegerException
     */
    protected function setRevenue($value)
    {
        if (!is_float($value) && !is_int($value)) {
            throw new FieldNotAFloatOrIntegerException('revenue');
        }

        $this->properties['revenue'] = $value;
    }

    /**
     * @param float|int $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAFloatOrIntegerException
     */
    protected function setValue($value)
    {
        if (!is_float($value) && !is_int($value)) {
            throw new FieldNotAFloatOrIntegerException('value');
        }

        $this->properties['value'] = $value;
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