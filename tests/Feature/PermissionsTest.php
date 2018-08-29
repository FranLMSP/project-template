<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\MethodModuleUser;
use App\Module;
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
        $this->withoutExceptionHandling();
        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se crea un módulo
        $module = factory(Module::class)->create([
            'name' => 'Nombre del módulo',
            'description' => 'Descripción del módulo',
            'url' => 'permissions/users/{user}',
            'api' => true,
        ]);
        $moduleTwo = factory(Module::class)->create([
            'name' => 'Nombre del módulo',
            'description' => 'Descripción del módulo',
            'url' => 'permissions/users',
            'api' => true,
        ]);

        //Se crea un metodo
        $method = factory(Method::class)->create([
            'name' => 'PUT',
            'description' => 'Modificar'
        ]);
        //Se crea otro método que es el que se va a personalizar
        $methodTwo = factory(Method::class)->create([
            'name' => 'GET',
            'description' => 'Listar/Obtener'
        ]);

        //Se asigna una acción
        $action = factory(MethodModuleUser::class)->create([
            'method_id' => $method->id,
            'module_id' => $module->id,
            'user_id' => $user->id,
        ]);

        //Ya el usuario debería poder modificar permisos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('PUT', '/api/permissions/users/'.$user->id, [
            'permissions' => [ //array de permisos
                [
                    'method_id' => $method->id,
                    'module_id' => $module->id,
                ],
                [
                    'method_id' => $methodTwo->id,
                    'module_id' => $moduleTwo->id,
                ],
            ],
        ])->assertStatus(200);


        //Nos aseguramos de que se haya guardado bien en la base de datos
        $this->assertDatabaseHas('method_module_user', [
            'method_id' => $method->id,
            'module_id' => $module->id,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('method_module_user', [
            'method_id' => $methodTwo->id,
            'module_id' => $moduleTwo->id,
            'user_id' => $user->id,
        ]);
        //Solo deberían haber dos registros porque se borraron los anteriores
        $this->assertTrue(MethodModuleUser::count() == 2);

        //Se prueba que el nuevo permiso funcione
        $this->json('GET', '/api/permissions/users/')
            ->assertStatus(200);
    }
}
