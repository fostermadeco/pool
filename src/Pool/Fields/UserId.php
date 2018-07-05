<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Contracts\Field;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

class UserId implements Field
{
    /**
     * *waves hand* "You don't need to see his identification"
     *
     * @var string
     */
    protected $anonymousId;

    /**
     * Application configuration for Segment
     *
     * @var array
     */
    protected $config;

    /**
     * The id of the user
     *
     * @var string
     */
    protected $userId;

    /**
     * User constructor.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $model
     */
    public function __construct(Authenticatable $model = null)
    {
        $this->config = config('segment');

        if (!is_null($model)) {
            $this->setUserId($model);
        } else {
            $this->setAnonymousId();
        }
    }

    /**
     * Set an anonymous user id. This should only be used if you don't know who the user is.
     */
    public function setAnonymousId()
    {
        $this->anonymousId = Str::uuid()->toString();
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $model
     */
    public function setUserId(Authenticatable $model)
    {
        $attribute = $this->config['user_id'];

        if ($attribute == 'key') {
            $this->userId = $model->getKey();
        } else {
            $this->userId = $model->$attribute;
        }
    }

    public function toArray()
    {
        if (isset($this->userId)) {
            return ["userId" => $this->userId];
        }

        return ["anonymousId" => $this->anonymousId];
    }
}