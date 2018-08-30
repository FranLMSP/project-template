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
     * Datos necesarios para editar rol pueden ser cargados.
     *
     * @test
     */
    public function role_edit_data_can_be_listed()
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
                'url' => 'roles/{role}/edit',
                'method' => 'GET'
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/roles/'.$role->id.'/edit')
        ->assertStatus(200)
        ->assertExactJson([
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description
            ],
        ]);
    }

    /**
     * Rol puede ser actualizado.
     *
     * @test
     */
    public function role_can_be_updated()
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
                'url' => 'roles/{role}',
                'method' => 'PUT'
            ]
        ]);

        $role = factory(Role::class)->create();

        //Se prueba que se pueda crear.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->put('/api/roles/'.$role->id, [
            'name' => 'Admin',
            'description' => 'Usuarios con privilegios de administrador',
        ])
        ->assertStatus(200);

        //Verificar que el rol se haya modificado correctamente
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Admin',
            'description' => 'Usuarios con privilegios de administrador',
        ]);
    }

    /**
     * Un rol puede ser encontrado.
     *
     * @test
     */
    public function role_can_be_finded()
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
                'url' => 'roles/{role}',
                'method' => 'GET'
            ]
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/roles/'.$role->id)
        ->assertStatus(200)
        ->assertExactJson([
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description
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
