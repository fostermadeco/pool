<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotADateException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnObjectOrArrayException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

class IdentityTraits implements Field
{
    /**
     * @var array
     */
    public $traits = [];

    /**
     * @var array
     */
    public static $reservedTraits = [
        'address', 'age', 'avatar', 'birthday', 'company', 'created_at', 'description', 'email',
        'first_name', 'gender', 'id', 'last_name', 'name', 'phone', 'title', 'username', 'website',
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
     * @param array $array
     * @return \FosterMadeCo\Pool\Fields\IdentityTraits
     * @throws \FosterMadeCo\Pool\Exceptions\ArrayKeyRequiredException
     */
    public static function createFromArray(array $array)
    {
        $traits = app()->make(IdentityTraits::class);

        foreach ($array as $attribute => $value) {
            if (is_int($attribute)) {
                // The value needs to be a string
                if (!is_string($value)) {
                    throw new ArrayKeyRequiredException();
                }

                $traits->$value = $value;
            } else {
                $traits->$attribute = $value;
            }
        }

        return $traits;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $model
     * @return \FosterMadeCo\Pool\Fields\IdentityTraits
     */
    public static function createFromModel(Authenticatable $model)
    {
        $traits = app()->make(IdentityTraits::class);

        foreach ($model->traits as $attribute => $value) {
            if (is_int($attribute)) {
                $traits->$value = $model->$value;
            } else {
                $traits->$attribute = $model->$value;
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
     * @param int $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException
     */
    protected function setAge($value)
    {
        if (!is_int($value)) {
            throw new FieldNotAnIntegerException('age');
        }

        $this->traits['age'] = $value;
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
    protected function setBirthday($value)
    {
        $validation = $this->validator->make([$value], ['date']);

        if ($validation->fails()) {
            throw new FieldNotADateException('birthday');
        }

        $this->traits['birthday'] = $value;
    }

    /**
     * @param object|array $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnObjectOrArrayException
     */
    protected function setCompany($value)
    {
        if (gettype($value) === 'array') {
            $this->traits['company'] = Company::createFromArray($value);
        } elseif (gettype($value) === 'object') {
            $this->traits['company'] = Company::createFromObject($value);
        } else {
            throw new FieldNotAnObjectOrArrayException('company');
        }
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
            dump($value);
            throw new FieldNotAnEmailException('email');
        }

        $this->traits['email'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setFirstName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('first name');
        }

        $this->traits['first_name'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setGender($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('gender');
        }

        $this->traits['gender'] = $value;
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
    protected function setLastName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('last name');
        }

        $this->traits['last_name'] = $value;
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
    protected function setPhone($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('phone');
        }

        $this->traits['phone'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setTitle($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('title');
        }

        $this->traits['title'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setUsername($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('username');
        }

        $this->traits['username'] = $value;
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