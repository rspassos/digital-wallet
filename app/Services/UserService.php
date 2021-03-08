<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;

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
}
