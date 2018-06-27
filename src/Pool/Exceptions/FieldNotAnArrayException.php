<?php

namespace FosterMadeCo\Pool\Exceptions;

class FieldNotAnArrayException extends FieldInvalidException
{
    /**
     * Sets the exception message.
     *
     * @param string $field
     */
    public function setMessage($field)
    {
        $this->message = "The {$field} field must be an array.";
    }
}