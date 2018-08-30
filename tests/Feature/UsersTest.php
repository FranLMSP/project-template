<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Role;
use App\Module;
use App\Method;
use App\MethodModuleUser;

/**
 * Este test se va a encargar de probar el CRUD de usuarios.
 * Se probará si se pueden crear y modificar usuarios mediante
 * la API y heredar privilegios de los roles.
 *
 */
class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Datos necesarios para crear usuarios pueden ser cargados.
     *
     * @test
     */
    public function user_create_data_can_be_listed()
    {
        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users/create',
                'method' => 'GET'
            ]
        ]);

        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/users/create')
        ->assertStatus(200)
        ->assertExactJson([
            'roles' => [
                [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description
                ]
            ]
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
