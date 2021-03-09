<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test if route exists
     *
     * @return void
     */
    public function test_users_route()
    {
        $response = $this->get(route('users'));
        $response->assertStatus(200);
    }
}
