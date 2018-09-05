<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class ProfileTest extends TestCase
{
    /**
     * Usuario puede ver su perfil.
     *
     * @test
     */
    public function user_can_see_his_own_profile()
    {
        //Se crea un usuario
        $user = factory(User::class)->create([
            'id' => 1,
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/profile')
        ->assertStatus(200)
        ->assertExactJson([
            'me' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'created_at' => (string)$user->created_at,
                'updated_at' => (string)$user->updated_at,
                'role' => [
                    'id' => $user->role->id,
                    'name' => $user->role->name,
                    'description' => $user->role->description,
                    'created_at' => (string)$user->role->created_at,
                    'updated_at' => (string)$user->role->updated_at,
                ]
            ];
        ]);
    }
}
