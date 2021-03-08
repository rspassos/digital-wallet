<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryContract
{
    public function create(array $data): array;
    public function update(array $data, int $id): array;
    public function find(int $id): array;
    public function approve(int $id): bool;
    public function cancel(int $id): bool;
}
