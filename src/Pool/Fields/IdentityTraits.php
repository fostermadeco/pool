<?php

namespace FosterMadeCo\Pool\Fields;

use DateTime;
use DateTimeInterface;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotADateException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Contracts\Validation\Factory;

class IdentityTraits extends BaseField
{
    /**
     * Fields that are validated.
     *
     * @var array
     */
    protected $validatedFields = [
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
     * @param object|array $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setAddress($value)
    {
        $this->fields['address'] = Address::create($value);

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException
     */
    public function setAge($value)
    {
        if (!is_int($value)) {
            throw new FieldNotAnIntegerException('age');
        }

        $this->fields['age'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    public function setAvatar($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('avatar');
        }

        $this->fields['avatar'] = $value;

        return $this;
    }

    /**
     * @param \DateTimeInterface|string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotADateException
     */
    public function setBirthday($value)
    {
        $validation = $this->validator->make([$value], ['date']);

        if ($validation->fails()) {
            throw new FieldNotADateException('birthday');
        }

        if (is_string($value)) {
            $value = new DateTime($value);
        }

        if ($value instanceof DateTimeInterface) {
            $value = $value->format(DateTime::ATOM);
        }

        $this->fields['birthday'] = $value;

        return $this;
    }

    /**
     * @param object|array $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setCompany($value)
    {
        $this->fields['company'] = Company::create($value);

        return $this;
    }

    /**
     * @param \DateTimeInterface|string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotADateException
     */
    public function setCreatedAt($value)
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

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setDescription($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('description');
        }

        $this->fields['description'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnEmailException
     */
    public function setEmail($value)
    {
        $validation = $this->validator->make([$value], ['email']);

        if ($validation->fails()) {
            throw new FieldNotAnEmailException('email');
        }

        $this->fields['email'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setFirstName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('first name');
        }

        $this->fields['first_name'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setGender($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('gender');
        }

        $this->fields['gender'] = $value;

        return $this;
    }

    /**
     * @param int|string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    public function setId($value)
    {
        if (!is_int($value) && !is_string($value)) {
            throw new FieldInvalidException('The id field either needs to be a string or integer.');
        }

        $this->fields['id'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setLastName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('last name');
        }

        $this->fields['last_name'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setName($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('name');
        }

        $this->fields['name'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setPhone($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('phone');
        }

        $this->fields['phone'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setTitle($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('title');
        }

        $this->fields['title'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setUsername($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('username');
        }

        $this->fields['username'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    public function setWebsite($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('website');
        }

        $this->fields['website'] = $value;

        return $this;
    }
}