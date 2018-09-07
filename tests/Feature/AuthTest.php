<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Este test se va a encargar de probar si un usuario
 * puede iniciar o cerrar sesión por medio de la API
 * con sus respectivos JsonWebToken.
 *
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un usuario puede iniciar sesión con credenciales válidas.
     *
     * @test
     */
    public function a_user_can_login_with_valid_credentials()
    {
        //Crear un usuario
        factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        //Hacer una petición de tipo POST a la ruta de login
        $this->json('POST', '/api/auth/login', [
            'username' => 'admin', //con este usuario
            'password' => '123456' //y esta clave
        ])->assertStatus(200) //Si el servidor responde con status 200, inició sesión correctaiemte
        //Espera que regrese los datos del token
        ->assertJson([
            'access_token' => true,
            'token_type' => true,
            'user' => true,
            'expires_in' => true
        ]);
    }

    /** 
     * Un usuario NO puede iniciar sesión con credenciales NO válidas.
     *
     * @test
     */
    public function a_user_can_not_login_with_invalid_credentials()
    {
        //Se crea un usuario
        factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        //Se hace una petición de tipo post a la ruta de login
        $this->post('/api/auth/login', [
            'username' => 'foo', //usuario invalido
            'password' => 'bar' // clave invalida
        ])->assertStatus(401); //Espera que el servidor responda status 401
    }

    /**
     * Un usuario puede cerrar sesión
     *
     * @test
     */
    public function a_user_can_logout()
    {
        $this->withoutExceptionHandling();
        //Se crea un usuario
        factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        //Inicia sesión
        $this->post('/api/auth/login', [
            'username' => 'admin',
            'password' => '123456'
        ]);

        //Solicita cerrar sesión
        $this->post('/api/auth/logout')
            //Finaliza correctamente
            ->assertStatus(200);

        //Se hace una petición a una ruta protegida
        $this->get('/api/protected')
            //Espera que el status sea 401
            ->assertStatus(401);
    }
}
