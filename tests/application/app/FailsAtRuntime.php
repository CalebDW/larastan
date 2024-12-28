<?php

namespace App;

use RuntimeException;

class FailsAtRuntime
{
    public function __construct()
    {
        throw new RuntimeException('This simulates a runtime error.');
    }
}
