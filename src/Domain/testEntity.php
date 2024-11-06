<?php

declare(strict_types=1);

namespace Domain;

use Application\test;
use Doctrine\Common\Collections\ArrayCollection;
class testEntity {
    public ArrayCollection $analytics;

    public function test(){
        $test = new test();
    }

}