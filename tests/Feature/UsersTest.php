<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

/**
* Este test se va a encargar de probar el CRUD de usuarios.
* Se probará si se pueden crear y modificar usuarios mediante
* la API y heredar privilegios de los roles.
*/
class UsersTest extends TestCase
{
    /**
     * Permisos pueden ser asignados a un usuario.
     *
     * @test
     */
    public function testExample()
    {
        $this->assertTrue(true);
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
