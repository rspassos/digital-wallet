<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract
{
    public function all(): array;
    public function save(array $data): array;
    public function find(int $id): array;
    public function update(array $data, int $id): array;
}
