<?php

declare(strict_types=1);

namespace Domain\Admin;

class AdminEntity {
    public array $analytics;

    public function test(): void {
        $this->analytics = [
            'name' => 'test',
            'value' => 1,
        ];
    }
}