<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Transaction;
use App\Jobs\TransactionApproved;
use Illuminate\Support\Facades\Http;
use App\Services\Contracts\TransactionServiceContract;
use App\Repositories\Contracts\TransactionRepositoryContract;

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

    public function authorize(Transaction $transaction): bool
    {
        try {
            $response = Http::get(config('services.api.authorizer'));

            if ($response['message'] && $response['message'] == 'Autorizado') {
                $this->transactionRepository->approve($transaction->id);
                dispatch(new TransactionApproved($transaction));
                return true;
            }

            throw new Exception('Transaction not autorized.');

        } catch (Exception | Throwable $e) {
            $this->transactionRepository->cancel($transaction->id);
        }
        
        return true;
    }
}
