<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryContract
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all(): array
    {
        return $this->model->with('type:id,name,pay,receive')->get()->toArray();
    }

    public function save(array $data): array
    {
        return $this->model->create($data);
    }

    public function find(int $id): array
    {
        $user = $this->model->find($id);
        
        if($user) {
            return $user;
        }

        throw new Exception('User not found.');
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

}