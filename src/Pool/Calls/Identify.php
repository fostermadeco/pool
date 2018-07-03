<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Fields\IdentityTraits;
use Illuminate\Contracts\Auth\Authenticatable;
use Segment;

class Identify extends BaseCall
{
    /**
     * Attributes of the user to pass to Segment
     *
     * @var \FosterMadeCo\Pool\Fields\IdentityTraits
     */
    protected $traits;

    /**
     * Identify constructor.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct(Authenticatable $model = null)
    {
        parent::__construct();

        $this->setIdentificationKey($model);
        $this->setTraits($model);
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        if ($this->traits) {
            $message['traits'] = $this->traits->toArray();
        }

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
        return Segment::identify($this->getMessage());
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|array $traitSource
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setTraits($traitSource)
    {
        if ($traitSource instanceof Authenticatable) {
            if (!empty($traitSource->traits)) {
                $this->traits = IdentityTraits::createFromModel($traitSource);
            }
        } elseif (is_array($traitSource)) {
            $this->traits = IdentityTraits::createFromArray($traitSource);
        }
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     * @param array|null $traits
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call(Authenticatable $model = null, $traits = null)
    {
        $identify = new self($model);

        if (!is_null($traits)) {
            $identify->setTraits($traits);
        }

        return $identify->sendRequest();
    }
}