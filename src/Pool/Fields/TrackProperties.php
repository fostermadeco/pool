<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotAFloatOrIntegerException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;

class TrackProperties extends BaseField
{
    /**
     * @var array
     */
    public $validatedFields = [
        'currency', 'revenue', 'value',
    ];

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

        $this->fields['currency'] = $value;
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

        $this->fields['revenue'] = $value;
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

        $this->fields['value'] = $value;
    }
}