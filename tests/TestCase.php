<?php

namespace Tests;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @var
     */
    protected $userModel;

    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->userModel = $this->createUser([
            'email' => 'jdoe@example.com',
            'name' => 'John Doe'
        ]);
    }

    protected function createUser($attributes = [])
    {
        return new class($attributes) extends Model implements AuthenticatableContract
        {
            use Authenticatable;

            public $fillable = [
                'email',
                'name',
            ];

            public $traits = [
                'email',
                'name',
            ];
        };
    }

    protected function getPackageProviders($app)
    {
        return ['FosterMadeCo\Pool\PoolServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Analytics' => 'FosterMadeCo\Pool\Facades\Analytics',
        ];
    }
}