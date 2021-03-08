<?php

namespace App\Services\Contracts;

use App\Models\Transaction;

interface UserServiceContract
{
    public function all(): array;
    public function balance(int $id): float;
    public function canPay(int $id): bool;
    public function notifyTransaction(Transaction $transaction): bool;
}
