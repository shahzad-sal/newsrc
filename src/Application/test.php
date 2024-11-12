<?php

declare(strict_types=1);

namespace Application;

use Domain\testEntity;

class Test
{
    public function __construct()
    {
    }

    public function test()
    {
        $test = new testEntity();
        $test->analytics;
    }
}
