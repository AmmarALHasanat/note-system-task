<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    /** @test */
    public function user_can_register_successfully_with_valid_data()
    {
        $response = $this->register([
            'name'=>'test',
            'email'=>fake()->safeEmail(),
            'password'=>'password',
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function user_cannot_register_with_email_exists()
    {
        $response = $this->register([
            'name' => 'test',
            'email' => User::first()->email,
            'password' => 'password',
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => 'validation error',
            "errors"=> [
                "email"=>[
                    "The email has already been taken."],
            ]
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_email()
    {
        $response = $this->register([
            'name' => 'test',
            'email' => 'test',
            'password' => 'tsetpass',
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => 'validation error',
            "errors" => [
                "email" => [
                    "The email field must be a valid email address."
                ],
            ]
        ]);
    }

    /** @test */
    public function user_cannot_register_with_null_data()
    {
        $response = $this->register([
            'name' => '',
            'email' => '',
            'password' => '',
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => 'validation error',
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
            ]
        ]);
    }

    /** @test */
    public function user_cannot_register_with_password_less_6()
    {
        $response = $this->register([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => '123',
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            "message" => 'validation error',
            "errors" => [
                "password" => [
                    "The password field must be at least 6 characters."
                ],
            ]
        ]);
    }

    /** @test */
    public function user_can_login_successfully(){
        $user = User::first();
        $response = $this->login([
            'email'=>$user->email,
            'password'=>'password'
        ]);
        $token = $response->json('data.token');
        $response->assertStatus(200)->assertJson([
            "status" => true,
            "message"=> "User Logged In Successfully",
            'data'=>[
                "id"=> 1,
                "name"=> "Test User",
                "email"=> "test@example.com",
                "token"=> $token
            ]
        ]);
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $response = $this->login([
            'email'=>'fake',
            'password'=>'password'
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            'message' => 'validation error',
            "errors" => [
                "email"=> [
                    "The email field must be a valid email address."
                ]
            ]
        ]);
    }
    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        $response = $this->login([
            'email'=>User::first()->email,
            'password'=>'testpass'
        ]);
        $response->assertStatus(422)->assertJson([
            "status" => false,
            'message' => "Email & Password does not match with our record."
        ]);
    }

    /** @test */
    public function user_can_logout_successfully()
    {
        $user = User::first();
        $loginResponse = $this->login([
            'email' => $user->email,
            'password' => 'password'
        ]);
        $token = $loginResponse->json('data.token');

        $logoutResponse = $this->logout($token);

        $logoutResponse->assertStatus(200)->assertJson([
            'message' => "Logged out"
        ]);
    }


}
