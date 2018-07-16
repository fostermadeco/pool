<?php

namespace FosterMadeCo\Pool\Calls;

use FosterMadeCo\Pool\Fields\GroupTraits;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Segment;

class Group extends BaseCall
{
    /**
     * How Segment wil identify the group
     *
     * @var string|int
     */
    public $groupId;

    /**
     * Attributes of the user to pass to Segment
     *
     * @var \FosterMadeCo\Pool\Fields\GroupTraits
     */
    public $traits;

    /**
     * Group constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $group
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user = null
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function __construct(Model $group, Authenticatable $user = null)
    {
        parent::__construct();

        $this->setIdentificationKey($user);
        $this->setGroupIdentificationKey($group);
        $this->setTraits($group);
        $this->traits->validate(true, $this->validateFields);
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        $message = $this->identificationKey->toArray();

        $message['groupId'] = $this->groupId;

        if (!empty($this->traits)) {
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
        return Segment::group($this->getMessage());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $group
     */
    public function setGroupIdentificationKey($group)
    {
        $this->groupId = $group->getKey();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $group
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public function setTraits($group)
    {
        if (!empty($group->traits)) {
            $this->traits = GroupTraits::create($group);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $group
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user = null
     * @return bool
     * @throws \FosterMadeCo\Pool\Exceptions\PoolException
     */
    public static function call(Model $group, Authenticatable $user = null)
    {
        $group = new self($group, $user);

        return $group->sendRequest();
    }
}