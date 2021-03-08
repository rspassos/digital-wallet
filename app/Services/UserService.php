<?php

namespace App\Services;

use Exception;
use Throwable;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;

class UserService implements UserServiceContract
{
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryContract $userRepositoryContract
     */
    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepository = $userRepositoryContract;
    }

    public function all(): array
    {
        return $this->userRepository->all();
    }

    public function canPay(int $id): bool
    {
        if ($user = $this->userRepository->find($id)) {
            return boolval($user['type']['pay']);
        }

        return false;
    }

    public function balance(int $id): float
    {
        if ($user = $this->userRepository->find($id)) {
            return $user['balance'];
        }

        return 0.0;
    }

    public function pay(int $userId, float $value): array
    {
        $user = $this->userRepository->find($userId);

        return $this->userRepository->update(
            ['balance' => $user['balance'] - $value],
            $userId
        );
    }

    public function receive(int $userId, float $value): array
    {
        $user = $this->userRepository->find($userId);

        return $this->userRepository->update(
            ['balance' => $user['balance'] + $value],
            $userId
        );
    }

    public function notifyTransaction(Transaction $transaction): bool
    {
        try {
            $response = Http::get(config('services.api.notification'));

            if ($response['message'] && $response['message'] == 'Enviado') {
                Log::info('Transação '.$transaction->id.' notificada. ');
            }

            return true;
        } catch (Exception | Throwable $e) {
            Log::info('Transação '.$transaction->id.' falhou a ser notificada. ');
            return false;
        }

        return true;
    }
}
