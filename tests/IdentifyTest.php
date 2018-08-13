<?php

namespace Tests;

use FosterMadeCo\Pool\Calls\Identify;

class IdentifyTest extends TestCase
{
    /**
     * @test
     */
    public function basic_test()
    {
        $this->assertEquals('John Doe', $this->userModel->name);
    }
}