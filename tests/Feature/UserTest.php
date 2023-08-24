<?php

namespace Tests\Feature;

use Tests\TestCase;

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
//              ->assertJson([
//             'success'=>true,
//             'message' => 'User Created Successfully',
//             "token"=> '',]);
    }

}
