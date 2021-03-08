<?php

namespace App\Repositories;

use App\Repositories\Contracts\TransactionRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Transaction;
use Exception;

class TransactionRepository implements TransactionRepositoryContract
{
    private $model;

    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    public function create(array $data): array
    {
        $transaction = $this->model->create($data);

        if($transaction) {
            return $this->find($transaction->id);
        }

        throw new Exception('Transaction not created.');
    }

    public function update(array $data, int $id): array
    {    
        $updated = $this->model
            ->where('id', $id)
            ->update($data);

        if($updated) {
            return $this->find($id);
        }

        throw new Exception('Error on update.');
    }

    public function find(int $id): array
    {
        $transaction = $this->model->find($id);
        
        if($transaction) {
            return $transaction->toArray();
        }

        throw new Exception('Transaction not found.');
    }

    public function approve(int $id): bool
    {
        $this->model
            ->where('id', $id)
            ->update(['status' => 'approved']);
        
        return true;
    }

    public function cancel(int $id): bool
    {
        $this->model
            ->where('id', $id)
            ->update(['status' => 'canceled']);

        return true;
    }

}