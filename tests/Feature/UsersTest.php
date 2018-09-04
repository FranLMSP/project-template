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
use App\MethodModuleRole;

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
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
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
     * Usuario puede ser creado.
     *
     * @test
     */
    public function user_can_be_created()
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
                'url' => 'users',
                'method' => 'POST'
            ]
        ]);

        //Crear un rol para asignárselo al usuario a crear
        $role = factory(Role::class)->create();

        //Se asignan permisos a ese rol para que el usuarlo los pueda heredar
        $module = factory(Module::class)->create();
        $moduleTwo = factory(Module::class)->create();

        $method = factory(Method::class)->create();
        $methodTwo = factory(Method::class)->create();

        factory(MethodModuleRole::class)->create([
            'method_id' => $method->id,
            'module_id' => $module->id,
            'role_id' => $role->id,
        ]);
        factory(MethodModuleRole::class)->create([
            'method_id' => $methodTwo->id,
            'module_id' => $moduleTwo->id,
            'role_id' => $role->id,
        ]);

        //Se prueba que se pueda crear.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->post('/api/users/', [
            'username' => 'usuario',
            'email' => 'a@a.com',
            'password' => '12345678',
            'repeatPassword' => '12345678',
            'role_id' => $role->id,
        ])
        ->assertStatus(201);

        $newUser = User::where('email', 'a@a.com')->first();

        //Verificar que el usuario creado haya heredado los permisos
        $this->assertDatabaseHas('method_module_user', [
            'method_id' => $method->id,
            'module_id' => $module->id,
            'user_id' => $newUser->id,
        ]);
        $this->assertDatabaseHas('method_module_user', [
            'method_id' => $methodTwo->id,
            'module_id' => $moduleTwo->id,
            'user_id' => $newUser->id,
        ]);

        //Verificar que el usuario se haya creado correctamente
        $this->assertDatabaseHas('users', [
            'username' => 'usuario',
            'email' => 'a@a.com',
            'role_id' => $role->id,
        ]);
    }

    /**
     * Datos necesarios para editar usuarios pueden ser cargados.
     *
     * @test
     */
    public function user_edit_data_can_be_listed()
    {
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users/{user}/edit',
                'method' => 'GET'
            ]
        ]);


        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/users/'.$user->id.'/edit')
        ->assertStatus(200)
        ->assertExactJson([
            'roles' => [
                [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description
                ]
            ],
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role->id,
                'role' => [
                    'id' => $user->role->id,
                    'name' => $user->role->name,
                    'description' => $user->role->description,
                ],
            ]
        ]);
    }


    /**
     * Usuario puede ser actualizado.
     *
     * @test
     */
    public function user_can_be_updated()
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
                'url' => 'users/{user}',
                'method' => 'PUT'
            ]
        ]);

        //Crear un rol para asignárselo al usuario a crear
        $newRole = factory(Role::class)->create();

        //Se prueba que se pueda crear.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->put('/api/users/'.$user->id, [
            'username' => 'usuario',
            'email' => 'a@a.com',
            'password' => '12345678',
            'repeatPassword' => '12345678',
            'role_id' => $newRole->id,
        ])
        ->assertStatus(200);

        //Verificar que el usuario se haya creado correctamente
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'usuario',
            'email' => 'a@a.com',
            'role_id' => $newRole->id,
        ]);
    }


    /**
     * Usuarios pueden ser listados.
     *
     * @test
     */
    public function users_can_be_listed()
    {
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users',
                'method' => 'GET'
            ]
        ]);


        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/users/')
        ->assertStatus(200)
        ->assertExactJson([
            'users' => [
                [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role_id' => $role->id,
                    'role' => [
                        'id' => $role->id,
                        'name' => $role->name,
                        'description' => $role->description,
                    ],
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
     * Un usuario pueden ser encontrado.
     *
     * @test
     */
    public function one_user_can_be_finded()
    {
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users/{user}',
                'method' => 'GET'
            ]
        ]);


        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/users/'.$user->id)
        ->assertStatus(200)
        ->assertExactJson([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $role->id,
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description,
                ],
            ],
        ]);
    }

    /**
     * Un usuario pueden ser borrado.
     *
     * @test
     */
    public function one_user_can_be_deleted()
    {
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
        ]);

        $newUser = factory(User::class)->create();

        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users/{user}',
                'method' => 'DELETE'
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->delete('/api/users/'.$newUser->id)
        ->assertStatus(200);

        //Se comprueba que se haya borrado el usuario correctamente
        $this->assertDatabaseMissing('users', [
            'id' => $newUser->id
        ]);
    }

    /**
     * Se pueden cambiar las contraseñas de los usuarios.
     *
     * @test
     */
    public function user_password_can_be_changed()
    {
        //Crear un rol para listarlo después
        $role = factory(Role::class)->create();

        //Se crea un usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
        ]);
        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Se asignan los permisos para interactuar con los modulos
        $this->assignPermissions([
            [
                'user_id' => $user->id,
                'url' => 'users/{user}/password',
                'method' => 'PUT'
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->put('/api/users/'.$user->id.'/password', [
            'password' => '12345678',
            'repeatPassword' => '12345678'
        ])
        ->assertStatus(200);
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
