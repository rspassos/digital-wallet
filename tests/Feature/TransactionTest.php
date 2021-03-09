<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    private $common;
    private $shopkeeper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutNotifications();

        $this->common = User::factory()->common()->create([
            'balance' => 1000
        ]);

        $this->shopkeeper = User::factory()->shopkeeper()->create([
            'balance' => 1000
        ]);
    }

    /**
     * Valid transaction from common user.
     *
     * @return void
     */
    public function test_valid_common_transaction()
    {
        $response = $this->postJson(route('transaction.store'),[
            'payer' => $this->common->id,
            'payee' => $this->shopkeeper->id,
            'value' => 500
        ]);
        
        // Created
        $response
            ->assertStatus(201)
            ->assertJson([
                'value' => '500.00',
                'payer' => $this->common->id,
                'payee' => $this->shopkeeper->id,
                'status' => 'approved'
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->common->id,
            'balance' => 500
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->shopkeeper->id,
            'balance' => 1500
        ]);
    }

    /**
     * Invalid transaction from common user without balance.
     *
     * @return void
     */
    public function test_common_transaction_without_balance()
    {
        $response = $this->postJson(route('transaction.store'),[
            'payer' => $this->common->id,
            'payee' => $this->shopkeeper->id,
            'value' => 1500
        ]);
        
        //Must be Unprocessable Entity
        $response
            ->assertStatus(422);

        $this->assertDatabaseHas('users', [
            'id' => $this->common->id,
            'balance' => 1000
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->shopkeeper->id,
            'balance' => 1000
        ]);
    }

     /**
     * Invalid transaction from common user without balance.
     *
     * @return void
     */
    public function test_shopkeeper_transaction()
    {
        $response = $this->postJson(route('transaction.store'),[
            'payer' => $this->shopkeeper->id,
            'payee' => $this->common->id,
            'value' => 1500
        ]);
        
        //Must be Forbidden
        $response
            ->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $this->common->id,
            'balance' => 1000
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->shopkeeper->id,
            'balance' => 1000
        ]);
    }

    /**
     * Valid transaction from common user.
     *
     * @return void
     */
    public function test_invalid_transaction()
    {
        $response = $this->postJson(route('transaction.store'),[
            'payee' => $this->shopkeeper->id,
            'value' => 500,
        ]);
        
        // Created
        $response
            ->assertStatus(500);

        $this->assertDatabaseHas('users', [
            'id' => $this->common->id,
            'balance' => 1000
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->shopkeeper->id,
            'balance' => 1000
        ]);
    }
}
