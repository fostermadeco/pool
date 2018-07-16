<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;

class Company extends BaseField
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
        'employee_count', 'id', 'industry', 'name', 'plan',
    ];

    /**
     * @param int $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAnIntegerException
     */
    public function setEmployeeCount($value)
    {
        if (!is_int($value)) {
            throw new FieldNotAnIntegerException('employee_count');
        }

        $this->fields['employee_count'] = $value;
    }

    /**
     * @param int|string $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    public function setId($value)
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
    public function setIndustry($value)
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
    public function setName($value)
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
    public function setPlan($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('plan');
        }

        $this->fields['plan'] = $value;
    }
}