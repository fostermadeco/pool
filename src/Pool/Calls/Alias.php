<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use Illuminate\Contracts\Auth\Authenticatable;
use Segment;

class Alias extends BaseCall
{
    /**
     * @var string|int
     */
    public $previousId;

    /**
     * Key of Authenticatable model
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $userId;

    /**
     * Alias constructor.
     * @param string|int $previousId
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct($previousId, Authenticatable $user)
    {
        parent::__construct();

        $this->setPreviousId($previousId);
        $this->setIdentificationKey($user);
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldInvalidException
     */
    public function setPreviousId($value)
    {
        if (!is_int($value) && !is_string($value)) {
            throw new FieldInvalidException('The previous id field either needs to be a string or integer.');
        }

        $this->previousId = $value;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        $message['previousId'] = $this->previousId;

        if ($this->context) {
            $message['context'] = $this->context->toArray();
        }

        if ($this->integrations) {
            $message['integrations'] = $this->integrations;
        }

        return $message;
    }

    /**
     * @return bool
     */
    public function sendRequest()
    {
        return Segment::alias($this->getMessage());
    }

    /**
     * @param string|int $previousId
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call($previousId, Authenticatable $user)
    {
        $alias = new self($previousId, $user);

        return $alias->sendRequest();
    }
}