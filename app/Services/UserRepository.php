<?php

namespace App\Services;

class UserRepository
{
    public function __construct(protected Logger $logger) {}

    public function find(int $id): array
    {
        $this->logger->log("Finding user #{$id}");
        return ['id' => $id, 'name' => 'Razvan', 'email' => 'razvan@example.com'];
    }

    public function all(): array
    {
        $this->logger->log("Fetching all users");
        return [
            ['id' => 1, 'name' => 'Razvan'],
            ['id' => 2, 'name' => 'Alex'],
        ];
    }
}