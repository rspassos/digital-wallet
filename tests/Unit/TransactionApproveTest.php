<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Jobs\TransactionApproved;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionApproveTest extends TestCase
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
    public function test_transaction_approve()
    {
        $transaction = Transaction::withoutEvents(function () {
            return Transaction::query()->create([
                'payer' => $this->common->id,
                'payee' => $this->shopkeeper->id,
                'value' => 500,
                'status' => 'approved'
            ]);
        });

        dispatch(new TransactionApproved($transaction));

        $this->assertDatabaseHas('users', [
            'id' => $this->common->id,
            'balance' => 500
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->shopkeeper->id,
            'balance' => 1500
        ]);
    }
}
