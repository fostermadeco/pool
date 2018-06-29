<?php

namespace FosterMadeCo\Pool\Fields;

use DateTime;
use DateTimeInterface;
use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotADateException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnObjectOrArrayException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

class GroupTraits
{
    /**
     * @var array
     */
    public $traits = [];

    /**
     * @var array
     */
    public static $reservedTraits = [
        'address', 'avatar', 'created_at', 'description', 'email', 'employees',
        'id', 'industry', 'name', 'plan', 'phone', 'website',
    ];

    /**
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validator;

    /**
     * Traits constructor.
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
        if (in_array(Str::snake($name), $this->traits)) {
            return $this->traits[Str::snake($name)];
        }

        return $this->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __set($name, $value)
    {
        if ($this->isReservedTrait($name)) {
            $method = 'set' . Str::studly($name);

            $this->{$method}($value);
        } else {
            $this->traits[$name] = $value;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $traits = [];

        foreach ($this->traits as $attribute => $value) {
            if (is_object($value)) {
                $traits[$attribute] = $value->toArray();
            } else {
                $traits[$attribute] = $value;
            }
        }

        return $traits;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \FosterMadeCo\Pool\Fields\GroupTraits
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function create(Model $group)
    {
        $traits = app()->make(self::class);

        foreach ($group->traits as $attribute => $value) {
            if (is_int($attribute)) {
                $traits->$value = $group->$value;
            } else {
                $traits->$attribute = $group->$value;
            }
        }

        return $traits;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isReservedTrait($name)
    {
        return in_array(Str::snake($name), self::$reservedTraits);
    }

    /**
     * @param object|array $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnObjectOrArrayException
     */
    protected function setAddress($value)
    {
        if (gettype($value) === 'array') {
            $this->traits['address'] = Address::createFromArray($value);
        } elseif (gettype($value) === 'object') {
            $this->traits['address'] = Address::createFromObject($value);
        } else {
            throw new FieldNotAnObjectOrArrayException('address');
        }
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setAvatar($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('avatar');
        }

        $this->traits['avatar'] = $value;
    }

    /**
     * @param \DateTimeInterface|string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotADateException
     */
    protected function setCreatedAt($value)
    {
        $validation = $this->validator->make([$value], ['date']);

        if ($validation->fails()) {
            throw new FieldNotADateException('created at');
        }

        if (is_string($value)) {
            $value = new DateTime($value);
        }

        if ($value instanceof DateTimeInterface) {
            $value = $value->format(DateTime::ATOM);
        }

        $this->traits['created_at'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setDescription($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('description');
        }

        $this->traits['description'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException
     */
    protected function setEmail($value)
    {
        $validation = $this->validator->make([$value], ['email']);

        if ($validation->fails()) {
            throw new FieldNotAnEmailException('email');
        }

        $this->traits['email'] = $value;
    }

    /**
     * @param int|string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    protected function setEmployees($value)
    {
        if (!is_numeric($value) && (int)$value == $value) {
            throw new FieldInvalidException('The employees field needs to be a whole number.');
        }

        $this->traits['employees'] = $value;
    }

    /**
     * @param int|string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    protected function setId($value)
    {
        if (!is_int($value) && !is_string($value)) {
            throw new FieldInvalidException('The id field either needs to be a string or integer.');
        }

        $this->traits['id'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setIndustry($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('industry');
        }

        $this->traits['industry'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('name');
        }

        $this->traits['name'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setPlan($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('plan');
        }

        $this->traits['plan'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setPhone($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('phone');
        }

        $this->traits['phone'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setWebsite($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('website');
        }

        $this->traits['website'] = $value;
    }
}