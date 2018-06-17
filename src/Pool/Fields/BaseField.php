<?php

namespace FosterMadeCo\Pool\Fields;

use Illuminate\Support\Str;

class BaseField implements Field
{
    /**
     * @var array
     */
    public $fields = [];

    /**
     * @var array
     */
    public static $allowedFields = [];

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array(Str::snake($name), $this->fields)) {
            return $this->fields[Str::snake($name)];
        }

        return $this->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($this->isAllowedField($name)) {
            $this->{'set' . Str::studly($name)}($value);
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isAllowedField($name)
    {
        return in_array(Str::snake($name), static::$allowedFields);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $fields = [];

        foreach ($this->fields as $attribute => $value) {
            if (is_object($value)) {
                $fields[$attribute] = $value->toArray();
            } else {
                $fields[$attribute] = $value;
            }
        }

        return $fields;
    }

    /**
     * @param array $array
     * @return \FosterMadeCo\Pool\Fields\BaseField
     */
    public static function createFromArray(array $array)
    {
        $baseField = new static;

        foreach (static::$allowedFields as $field) {
            if (array_key_exists($field, $array)) {
                $baseField->$field = $array[$field];
            } elseif (array_key_exists(Str::camel($field), $array)) {
                $baseField->$field = $array[Str::camel($field)];
            }
        }

        return $baseField;
    }

    /**
     * @param object $object
     * @return \FosterMadeCo\Pool\Fields\BaseField
     */
    public static function createFromObject($object)
    {
        $baseField = new static;

        foreach (static::$allowedFields as $field) {
            if (!empty($object->$field)) {
                $baseField->$field = $object->$field;
            } elseif (!empty($object->{Str::camel($field)})) {
                $baseField->$field = $object->{Str::camel($field)};
            }
        }

        return $baseField;
    }
}