<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\UserService;
use App\Services\TransactionService;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\TransactionServiceContract;

use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\TransactionRepositoryContract;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(TransactionRepositoryContract::class, TransactionRepository::class);
        $this->app->bind(TransactionServiceContract::class, TransactionService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
