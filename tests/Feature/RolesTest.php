<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Role;
use App\Method;
use App\Module;
use App\MethodModuleUser;

class RolesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Rol puede ser creado.
     *
     * @test
     */
    public function role_can_be_created()
    {
        //Se crea un usuario
        $user = factory(User::class)->create([
            'id' => 1,
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'roles',
                'method' => 'POST'
            ]
        ]);

        //Se prueba que se pueda crear.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->post('/api/roles/', [
            'name' => 'Admin',
            'description' => 'Usuarios con privilegios de administrador',
        ])
        ->assertStatus(201);

        //Verificar que el usuario se haya creado correctamente
        $this->assertDatabaseHas('roles', [
            'name' => 'Admin',
            'description' => 'Usuarios con privilegios de administrador',
        ]);
    }


    /**
     * Permisos de todos los usuarios pueden ser listados.
     * Este método estará presente en las pruebas necesarias.
     *
     * @param array $permissions Arreglo con los permisos a asignar para el usuario
     *   Con un subarray que contiene la ID del usuario, la URL y el metodo HTTP
     *   Ejemplo: [['user_id' => 1, 'url' => 'ruta/{id}', 'method' => 'GET']]
     *
     * @return void
     */
    private function assignPermissions(array $permissions) {
        foreach($permissions as $permission) {
            factory(MethodModuleUser::class)->create([
                'user_id' => $permission['user_id'],
                'module_id' => factory(Module::class)->create([
                    'url' => $permission['url']
                ])->id,
                'method_id' => factory(Method::class)->create([
                    'name' => $permission['method']
                ])->id
            ]);
        }
    }
}
