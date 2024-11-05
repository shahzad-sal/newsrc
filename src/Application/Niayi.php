<?php

declare(strict_types=1);

namespace Application;

use Domain\testEntity;

class Niayi {
    public function __construct() {

    }

    public function test() {
        $test = new testEntity();
        $test->analytics;
    }
}