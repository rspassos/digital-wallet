<?php

namespace App\Services\Contracts;

interface UserServiceContract
{
    public function all(): array;
    public function balance(int $id): float;
    public function canPay(int $id): bool;
}
