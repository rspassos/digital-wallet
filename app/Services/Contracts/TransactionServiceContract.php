<?php

namespace App\Services\Contracts;

use App\Models\Transaction;

interface TransactionServiceContract
{
    public function add(array $data): array;
    public function authorize(Transaction $transaction): bool;
}
