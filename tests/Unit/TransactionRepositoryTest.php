<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Contracts\TransactionRepositoryContract;

class TransactionRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private $common;
    private $shopkeeper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->common = User::factory()->common()->create([
            'balance' => 1000
        ]);

        $this->shopkeeper = User::factory()->shopkeeper()->create([
            'balance' => 1000
        ]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_transaction_create()
    {
        $transaction = app(TransactionRepository::class);

        $result = $transaction->create([
            'payee' => $this->common->id,
            'payer' => $this->shopkeeper->id,
            'value' => '100'
        ]);

        $this->assertArrayHasKey('payee', $result);
        $this->assertArrayHasKey('payer', $result);
        $this->assertArrayHasKey('value', $result);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_transaction_approve()
    {
        $transaction = Transaction::withoutEvents(function () {
            return Transaction::query()->create([
                'payer' => $this->common->id,
                'payee' => $this->shopkeeper->id,
                'value' => 500,
                'status' => 'pending'
            ]);
        });

        $this->assertStringContainsString('pending', $transaction->status);

        $TransactionRepository = app(TransactionRepository::class);
        $TransactionRepository->approve($transaction->id);
        $result = $TransactionRepository->find($transaction->id);

        $this->assertStringContainsString('approved', $result['status']);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_transaction_cancel()
    {
        $transaction = Transaction::withoutEvents(function () {
            return Transaction::query()->create([
                'payer' => $this->common->id,
                'payee' => $this->shopkeeper->id,
                'value' => 500,
                'status' => 'pending'
            ]);
        });

        $this->assertStringContainsString('pending', $transaction->status);

        $TransactionRepository = app(TransactionRepository::class);
        $TransactionRepository->cancel($transaction->id);
        $result = $TransactionRepository->find($transaction->id);

        $this->assertStringContainsString('canceled', $result['status']);
    }
}
