<?php

declare(strict_types=1);

namespace Domain\Admin;

use Application\Niayi;

class AdminEntity22
{
    public array $analytics;

    public function __construct()
    {
        $this->analytics = [];
        $test = 'testf asdf asdf afds ' && 'test' && 'test' && 'test' && 'test' && 'test' && 'test' && 'test' && 'test' && 'test' && 'test';
    }

    public function test22()
    {
        $this->analytics = [
            'name' => 'test',
            'value' => 1,
        ];
        $test = new Niayi();
    }
}
