<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Role;
use App\ActionRole;
use App\ActionUser;
use App\Module;
use App\Route;
use App\Method;

/**
* Este test se va a encargar de probar si se pueden asignar
* permisos a los roles y a los usuarios por medio del API.
*
*/
class PermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Permisos pueden ser asignados a un usuario.
     *
     * @test
     */
    public function permissions_can_be_assigned_to_user()
    {
        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        //Se crea un módulo
        $module = factory(Route::class)->create([
            'name' => 'Nombre del módulo',
            'url' => 'permisos',
        ]);

        //Se crean una rutas API
        $route = factory(Route::class)->create([
            'url' => 'permisos/usuarios/{id}',
            'description' => 'Permisos de usuario especifico',
            'module_id' => $module->id,
        ]);
        $routeTwo = factory(Route::class)->create([
            'url' => 'permisos/usuarios/',
            'description' => 'Listar usuarios y permisos',
            'module_id' => $module->id,
        ]);

        //Se crea un metodo
        $method = factory(Route::class)->create([
            'name' => 'PUT',
            'description' => 'Modificar'
        ]);
        //Se crea otro método que es el que se va a personalizar
        $methodTwo = factory(Route::class)->create([
            'name' => 'GET',
            'description' => 'Listar/Obtener'
        ]);

        //Se asigna una acción
        $action = factory(Route::class)->create([
            'name' => 'Modificar permisos',
            'method_id' => $method->id,
            'route_id' => $route->id,
            'user_id' => $user->id,
        ]);

        //Ya el usuario debería poder modificar permisos.
        $this->json('PUT', '/api/permisos/usuarios/'.$user->id, [
            'permissions' => [ //array de permisos
                [
                    'name' => 'Nombre personalizado del permiso',
                    'method_id' => $method->id,
                    'route_id' => $route->id,
                ],
                [
                    'name' => 'Nombre personalizado segundo del permiso',
                    'method_id' => $methodTwo->id,
                    'route_id' => $routeTwo->id,
                ],
            ],
        ])->assertStatus(200);

        //Ya el usuario debería poder modificar permisos.
        $this->json('POST', '/api/permisos/usuarios/'.$user->id, [
            'permissions' => [ //array de permisos
                [
                    'name' => 'Nombre personalizado del permiso',
                    'method_id' => $method->id,
                    'route_id' => $route->id,
                ],
                [
                    'name' => 'Nombre personalizado segundo del permiso',
                    'method_id' => $methodTwo->id,
                    'route_id' => $route->id,
                ],
            ],
        ])->assertStatus(200);

        //Se prueba que el nuevo permiso funcione
        $this->json('GET', '/api/permisos/usuarios/')
            ->assertStatus(200);
    }
}
