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

class ModulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Módulos de menús a los que el usuario tiene acceso pueden ser listados.
     *
     * @test
     */
    public function my_modules_menu_can_be_listed()
    {
        //Nuestro usuario
        $user = factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
        ]);

        //Otro usuario de prueba
        $anotherUser = factory(User::class)->create();

        //Obtenemos su token para la sesion
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        //Módulos para listar
        $moduleOne = factory(Module::class)->create([
            'name' => 'Primer módulo padre',
            'api' => false //listar
        ]);
        $moduleOneChild = factory(Module::class)->create([
            'name' => 'Primer módulo hijo',
            'api' => false, //listar,
            'module_id' => $moduleOne->id,
        ]);
        $moduleTwo = factory(Module::class)->create([
            'api' => false, //no listar
            'module_id' => NULL,
        ]);
        //Módulos de otro usuario que NO se va a listar
        $moduleThree = factory(Module::class)->create([
            'module_id' => NULL,
            'api' => true //no listar
        ]);
        $moduleFour = factory(Module::class)->create([
            'module_id' => NULL,
            'api' => true //no listar
        ]);

        //Método GET para listar
        $method = factory(Method::class)->create([
            'name' => 'GET'
        ]);

        //Se asignan los permisos correspondientes a cada usuario
        MethodModuleUser::insert([
            [
                //modulo a listar
                'method_id' => $method->id,
                'module_id' => $moduleOne->id,
                'user_id' => $user->id,
            ],
            [
                //modulo a listar
                'method_id' => $method->id,
                'module_id' => $moduleOneChild->id,
                'user_id' => $user->id,
            ],
            [
                //no listar
                'method_id' => $method->id,
                'module_id' => $moduleTwo->id,
                'user_id' => $user->id,
            ],
            [
                //no listar
                'method_id' => $method->id,
                'module_id' => $moduleThree->id,
                'user_id' => $anotherUser->id,
            ],
            [
                //no listar
                'method_id' => $method->id,
                'module_id' => $moduleFour->id,
                'user_id' => $anotherUser->id,
            ],
        ]);

        //Se prueba que se listen correctamente los datos.
        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->get('/api/modules/menu')
        ->assertStatus(200)
        ->assertExactJson([
            'modules' => [
                [
                    'id' => $moduleOne->id,
                    'name' => $moduleOne->name,
                    'url' => $moduleOne->url,
                    'icon' => $moduleOne->icon,
                    'priority' => $moduleOne->priority,
                    'description' => $moduleOne->description,
                    'api' => $moduleOne->api,
                    'active' => $moduleOne->active,
                    'module_id' => $moduleOne->module_id,
                    'childs' => [
                        [
                            'id' => $moduleOneChild->id,
                            'name' => $moduleOneChild->name,
                            'url' => $moduleOneChild->url,
                            'icon' => $moduleOneChild->icon,
                            'priority' => $moduleOneChild->priority,
                            'description' => $moduleOneChild->description,
                            'api' => $moduleOneChild->api,
                            'active' => $moduleOneChild->active,
                            'module_id' => $moduleOneChild->module_id,
                            'childs' => []
                        ]
                    ]
                ]
            ],
        ]);
    }

}
