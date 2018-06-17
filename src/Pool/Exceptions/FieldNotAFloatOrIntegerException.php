<?php

namespace FosterMadeCo\Pool\Exceptions;

class FieldNotAFloatOrIntegerException extends FieldInvalidException
{
    /**
     * Sets the exception message.
     *
     * @param string $field
     */
    public function setMessage($field)
    {
        $this->message = "The {$field} field must be of type float or integer.";
    }
}