<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Services\Contracts\TransactionServiceContract;

class TransactionObserver
{
    public function __construct(TransactionServiceContract $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $this->transactionService->authorize($transaction);
    }
}
