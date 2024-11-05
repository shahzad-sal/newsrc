<?php

declare(strict_types=1);

namespace Domain\Admin;



use Application\test;
use Doctrine\Common\Collections\ArrayCollection;
class AdminEntity {
    public ArrayCollection $analytics;


    public function test(){
        $test = new test();
    }

}