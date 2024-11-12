<?php

declare(strict_types=1);

namespace Domain\Admin;

use Application\Niayi;

class AdminEntity {
    public array $analytics;

    public function test(): void {
        $this->analytics = [
            'name' => 'test',
            'value' => 1,
        ];
        $test = new Niayi();
    }
}