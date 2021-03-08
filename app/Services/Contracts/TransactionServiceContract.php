<?php

namespace App\Services\Contracts;

interface TransactionServiceContract
{
    public function add(array $data): array;
}
