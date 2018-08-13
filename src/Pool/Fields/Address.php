<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;

class Address extends BaseField
{
    /**
     * Restrict the fields that can be added to the ones that are validated.
     *
     * @var bool
     */
    protected $restrictFields = true;

    /**
     * Fields that are validated.
     *
     * @var array
     */
    protected $validatedFields = [
        'city', 'country', 'postal_code', 'state', 'street',
    ];

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setCity($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('city');
        }

        $this->fields['city'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setCountry($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('country');
        }

        $this->fields['country'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setPostalCode($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('postal code');
        }

        $this->fields['postal_code'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setState($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('state');
        }

        $this->fields['state'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    public function setStreet($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('street');
        }

        $this->fields['street'] = $value;

        return $this;
    }
}