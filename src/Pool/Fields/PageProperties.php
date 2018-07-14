<?php

namespace FosterMadeCo\Pool\Fields;

use FosterMadeCo\Pool\Exceptions\FieldNotAnArrayException;
use FosterMadeCo\Pool\Exceptions\FieldInvalidException;
use FosterMadeCo\Pool\Exceptions\FieldNotAStringException;
use FosterMadeCo\Pool\Exceptions\FieldNotAUrlException;
use Illuminate\Contracts\Validation\Factory;

class PageProperties extends BaseField
{
    /**
     * @var array
     */
    public static $validatedFields = [
        'keywords', 'path', 'referrer', 'search', 'title', 'url',
    ];

    /**
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validator;

    /**
     * PageProperties constructor.
     *
     * @param \Illuminate\Contracts\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $value
     * @throws FieldNotAnArrayException
     */
    protected function setKeywords($value)
    {
        if (!is_array($value)) {
            throw new FieldNotAnArrayException('keywords');
        }
        array_walk($value, function ($item, $key) {
            if (!is_string($item)) {
                throw new FieldInvalidException('The keywords field needs to be an array of strings.');
            }
        });

        $this->fields['keywords'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setPath($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('path');
        }

        $this->fields['path'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setReferrer($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('referrer');
        }

        $this->fields['referrer'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setSearch($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('search');
        }

        $this->fields['search'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAStringException
     */
    protected function setTitle($value)
    {
        if (!is_string($value)) {
            throw new FieldNotAStringException('title');
        }

        $this->fields['title'] = $value;
    }

    /**
     * @param $value
     * @throws \FosterMadeCo\Pool\Exceptions\FieldNotAUrlException
     */
    protected function setUrl($value)
    {
        $validation = $this->validator->make([$value], ['url']);

        if ($validation->fails()) {
            throw new FieldNotAUrlException('url');
        }

        $this->fields['url'] = $value;
    }
}