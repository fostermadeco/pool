<?php

namespace FosterMadeCo\Pool\Fields;

use DateTime;
use DateTimeInterface;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotADateException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;

class GroupTraits extends BaseField
{
    /**
     * @var array
     */
    public static $validatedFields = [
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
     * @param object|array $value
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    protected function setAddress($value)
    {
        $this->fields['address'] = Address::create($value);
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

        $this->fields['avatar'] = $value;
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

        $this->fields['created_at'] = $value;
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

        $this->fields['description'] = $value;
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

        $this->fields['email'] = $value;
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

        $this->fields['employees'] = $value;
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

        $this->fields['id'] = $value;
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

        $this->fields['industry'] = $value;
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

        $this->fields['name'] = $value;
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

        $this->fields['plan'] = $value;
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

        $this->fields['phone'] = $value;
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

        $this->fields['website'] = $value;
    }
}