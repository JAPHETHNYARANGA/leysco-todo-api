<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('users.store'), $userData);

        $response->assertStatus(Response::HTTP_CREATED)
                ->assertJson([
                    'name' => 'John Doe', // Corrected case
                    'email' => 'johndoe@gmail.com',
                ]);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe', // Ensure database entry matches expected case
            'email' => 'johndoe@gmail.com',
        ]);        
    }


    public function test_it_can_login_a_user()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginData = [
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('login'), $loginData);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'email' => 'johndoe@example.com',
                 ]);
    }

   

}
