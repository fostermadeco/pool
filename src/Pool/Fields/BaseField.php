<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Contracts\Field;
use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseField implements Field
{
    /**
     * Data points that will be passed in the message
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Restrict the fields that can be added to the ones that are validated.
     *
     * @var bool
     */
    protected $restrictFields = false;

    /**
     * Fields that are validated.
     *
     * @var array
     */
    protected $validatedFields = [];

    /**
     * Validate the fields
     *
     * @var array
     */
    protected $validateFields = false;

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
     * Set a field
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($this->validateFields && $this->isValidatedField($name)) {
            $method = 'set' . Str::studly($name);

            $this->{$method}($value);
        } else {
            $this->fields[$name] = $value;
        }
    }

    /**
     * Shorthand for $this->valdidate($withChildren, false)
     *
     * @param boolean $withChildren
     */
    public function neglect($withChildren = true)
    {
        $this->validate($withChildren, false);
    }

    /**
     * Prevent items not in self::validatedFields from being in the array of return fields
     *
     * @param boolean $withChildren
     */
    public function restrict($withChildren = true, $setting = true)
    {
        $this->restrictFields = $setting;

        if ($withChildren) {
            foreach ($this->fields as $field) {
                if ($field instanceof self) {
                    $field->restrict($withChildren, $setting);
                }
            }
        }
    }

    /**
     * Return this object's fields as an array
     *
     * @return array
     */
    public function toArray()
    {
        $fields = [];

        foreach ($this->fields as $attribute => $value) {
            if (! $this->restrictFields || in_array($attribute, $this->validatedFields)) {
                if (is_object($value)) {
                    $fields[$attribute] = $value->toArray();
                } else {
                    $fields[$attribute] = $value;
                }
            }
        }

        return $fields;
    }

    /**
     * Shorthand for $this->restrict($withChildren, false)
     *
     * @param boolean $withChildren
     */
    public function unrestrict($withChildren = true)
    {
        $this->restrict($withChildren, false);
    }

    /**
     * Do or do not validate the fields when they are set. There is no try.
     *
     * @param boolean $withChildren
     * @param boolean $setting
     */
    public function validate($withChildren = true, $setting = true)
    {
        $this->validateFields = $setting;

        if ($withChildren) {
            foreach ($this->fields as $field) {
                if ($field instanceof self) {
                    $field->validate($withChildren, $setting);
                }
            }
        }
    }

    /**
     * Check if the field name is reserved and should be validated
     *
     * @param string $name
     * @return bool
     */
    public function isValidatedField($name)
    {
        return in_array(Str::snake($name), $this->validatedFields);
    }

    /**
     * Construct an instance of the fields
     *
     * @param \Illuminate\Database\Eloquent\Model|array $fieldSource
     * @return \FosterMadeCo\Pool\Fields\BaseField
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function create($fieldSource)
    {
        if (is_object($fieldSource) && $fieldSource instanceof Model) {
            return static::createFromModel($fieldSource);
        } elseif (is_array($fieldSource)) {
            return static::createFromArray($fieldSource);
        }

        throw new FieldInvalidException("The field must be generated from an Eloquent model or an array.");
    }

    /**
     * Construct the fields from a list on an array
     *
     * @param array $array
     * @return \FosterMadeCo\Pool\Fields\BaseField
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function createFromArray(array $array)
    {
        $field = app()->make(static::class);

        foreach ($array as $attribute => $value) {
            if (is_int($attribute)) {
                // The value needs to be a string
                if (!is_string($value)) {
                    throw new ArrayKeyRequiredException();
                }

                $field->$value = $value;
            } else {
                $field->$attribute = $value;
            }
        }

        return $field;
    }

    /**
     * Construct the fields from a list on an Eloquent model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public static function createFromModel(Model $model)
    {
        $field = app()->make(self::class);

        $fieldProperties = isset($model->traits) ? $model->traits
            : isset($model->segmentProperties) ? $model->segmentProperties : null;

        foreach ($fieldProperties as $attribute => $value) {
            if (is_int($attribute)) {
                $field->$value = $model->$value;
            } else {
                $field->$attribute = $model->$value;
            }
        }

        return $field;
    }
}