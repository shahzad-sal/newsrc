<?php

declare(strict_types=1);

namespace Domain;

use Application\Niayi;
use Application\test;
class testEntity {
    public ArrayCollection $analytics;

    public function test(){
        $test = new test();
    }

    public function needToBeTested(){
        $test = new Niayi();
    }

}