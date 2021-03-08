<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryContract;
use App\Services\Contracts\TransactionServiceContract;

class TransactionService implements TransactionServiceContract
{
    /**
     * @var TransactionRepositoryContract
     */
    private $transactionRepository;

    /**
     * TransactionService constructor.
     * @param TransactionRepositoryContract $transactionRepositoryContract
     */
    public function __construct(TransactionRepositoryContract $transactionRepositoryContract)
    {
        $this->transactionRepository = $transactionRepositoryContract;
    }

    public function add(array $data): array
    {
        return $this->transactionRepository->create($data);
    }
}
