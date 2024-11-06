<?php

declare(strict_types=1);

namespace Domain\Admin;

use Application\Niayi;
use Application\test;
use Doctrine\Common\Collections\ArrayCollection;
class AdminEntity {
    public ArrayCollection $analytics;


    public function test(){
        $test = new test();
    }

    public function newTest(){
        $test = new Niayi();
    }

    public function thrid(){
        $test = new Niayi();
    }

}