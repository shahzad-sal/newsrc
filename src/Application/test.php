<?php

declare(strict_types=1);

namespace Application;

use Domain\testEntity;

class test {
    public function __construct() {

    }

    public function test() {
        $test = new testEntity();
        $test->analytics;
    }
}