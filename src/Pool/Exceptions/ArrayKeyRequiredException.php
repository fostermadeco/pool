<?php

namespace FosterMadeCo\Pool\Exceptions;

class ArrayKeyRequiredException extends PoolException
{
    /**
     * Sets the exception message.
     */
    public function setMessage()
    {
        $this->message = "All non string values in array fields must have a key.";
    }
}