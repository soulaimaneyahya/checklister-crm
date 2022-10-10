<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test home.
     *
     * @return void
     */
    public function test_home()
    {
        $user = $this->user();
        $this->actingAs($user);
        
        $response = $this->get('/welcome');
        $response->assertStatus(200);
    }
}
