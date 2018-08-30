<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Role;
use App\MethodModuleUser;
use App\MethodModuleRole;
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

    /**
     * Permisos pueden ser asignados a un rol.
     *
     * @test
     */
    public function permissions_can_be_assigned_to_role()
    {
        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se crea un rol
        $role = factory(Role::class)->create();

        //Se crea un módulo
        $module = factory(Module::class)->create([
            'name' => 'Nombre del módulo',
            'description' => 'Descripción del módulo',
            'url' => 'permissions/roles/{role}',
            'api' => true,
        ]);
        $moduleTwo = factory(Module::class)->create([
            'name' => 'Nombre del módulo',
            'description' => 'Descripción del módulo',
            'url' => 'permissions/roles',
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

        //Se asigna una acción para que el usuario pueda modificar el rol
        $action = factory(MethodModuleUser::class)->create([
            'method_id' => $method->id,
            'module_id' => $module->id,
            'user_id' => $user->id,
        ]);

        //Ya el usuario debería poder modificar permisos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('PUT', '/api/permissions/roles/'.$role->id, [
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
        $this->assertDatabaseHas('method_module_role', [
            'method_id' => $method->id,
            'module_id' => $module->id,
            'role_id' => $role->id,
        ]);
        $this->assertDatabaseHas('method_module_role', [
            'method_id' => $methodTwo->id,
            'module_id' => $moduleTwo->id,
            'role_id' => $role->id,
        ]);
        //Solo deberían haber dos registros porque se borraron los anteriores
        $this->assertTrue(MethodModuleRole::count() == 2);
    }


    /**
     * Permisos de todos los usuarios pueden ser listados.
     *
     * @test
     */
    public function users_permissions_can_be_listed()
    {
        $this->withoutExceptionHandling();
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
                'url' => 'permissions/users',
                'method' => 'GET',
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/permissions/users/')
        ->assertStatus(200)
        ->assertExactJson([
            'users' => [
                [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'permissions' => [
                        [
                            'id' =>  $user->permissions[0]->id,
                            'method_id' => $user->permissions[0]->method->id,
                            'module_id' => $user->permissions[0]->module->id,
                            'user_id' => $user->id,
                            'created_at' => (string)$user->permissions[0]->created_at,
                            'updated_at' => (string)$user->permissions[0]->updated_at,
                            'module' => [
                                'id' => $user->permissions[0]->module->id,
                                'name' => $user->permissions[0]->module->name,
                                'description' => $user->permissions[0]->module->description,
                                'url' => $user->permissions[0]->module->url,
                                'api' => $user->permissions[0]->module->api,
                                'active' => $user->permissions[0]->module->active,
                            ],
                            'method' => [
                                'id' => $user->permissions[0]->method->id,
                                'name' => $user->permissions[0]->method->name,
                                'description' => $user->permissions[0]->method->description
                            ],
                        ]
                    ]
                ]
            ],
            'pagination' => [
                'total'        => 1,
                'current_page' => 1,
                'per_page'     => 10,
                'last_page'    => 1,
                'from'         => 1,
                'to'           => 1
            ]
        ]);
    }


    /**
     * Permisos de un solo usuario puede ser listado.
     *
     * @test
     */
    public function one_user_permissions_can_be_listed()
    {
        $this->withoutExceptionHandling();
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
                'url' => 'permissions/users/{user}',
                'method' => 'GET',
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/permissions/users/'.$user->id)
        ->assertStatus(200)
        ->assertExactJson([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'permissions' => [
                    [
                        'id' =>  $user->permissions[0]->id,
                        'method_id' => $user->permissions[0]->method->id,
                        'module_id' => $user->permissions[0]->module->id,
                        'user_id' => $user->id,
                        'created_at' => (string)$user->permissions[0]->created_at,
                        'updated_at' => (string)$user->permissions[0]->updated_at,
                        'module' => [
                            'id' => $user->permissions[0]->module->id,
                            'name' => $user->permissions[0]->module->name,
                            'description' => $user->permissions[0]->module->description,
                            'url' => $user->permissions[0]->module->url,
                            'api' => $user->permissions[0]->module->api,
                            'active' => $user->permissions[0]->module->active,
                        ],
                        'method' => [
                            'id' => $user->permissions[0]->method->id,
                            'name' => $user->permissions[0]->method->name,
                            'description' => $user->permissions[0]->method->description
                        ],
                    ]
                ]
            ],
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
