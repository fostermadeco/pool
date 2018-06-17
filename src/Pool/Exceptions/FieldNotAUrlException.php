<?php

namespace FosterMadeCo\Pool\Exceptions;

class FieldNotAUrlException extends FieldInvalidException
{
    /**
     * Sets the exception message.
     *
     * @param string $field
     */
    public function setMessage($field)
    {
        $this->message = "The {$field} field must be a valid url.";
    }
}