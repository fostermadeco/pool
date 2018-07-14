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
    public $restrictFields = true;

    /**
     * @var array
     */
    public $validatedFields = [
        'city', 'country', 'postal_code', 'state', 'street',
    ];

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setCity($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('city');
        }

        $this->fields['city'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setCountry($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('country');
        }

        $this->fields['country'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setPostalCode($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('postal code');
        }

        $this->fields['postal_code'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setState($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('state');
        }

        $this->fields['state'] = $value;
    }

    /**
     * @param string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setStreet($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('street');
        }

        $this->fields['street'] = $value;
    }
}