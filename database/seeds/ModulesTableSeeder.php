<?php

use Illuminate\Database\Seeder;
use App\Module;

use Illuminate\Routing\Router;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();

        //Módulos de MENU
        factory(Module::class)->create([
            'id' => 1,
            'name' => 'Configuración',
            'description' => 'Módulo padre para configuración',
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => NULL,
        ]);

        factory(Module::class)->create([
            'id' => 2,
            'name' => 'Usuarios',
            'description' => 'Módulo hijo para listar usuarios',
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => 1,
        ]);

        factory(Module::class)->create([
            'id' => 3,
            'name' => 'Listar',
            'description' => 'Módulo nieto para listar usuarios',
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/usuarios',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);

        factory(Module::class)->create([
            'id' => 4,
            'name' => 'Listar',
            'description' => 'Módulo nieto para interactuar usuarios API',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'users',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 5,
            'name' => 'Listar',
            'description' => 'Módulo nieto para interactuar usuarios API',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'users/{user}',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 6,
            'name' => 'Listar',
            'description' => 'Módulo nieto para listar datos necesarios para crear',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'users/create',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 7,
            'name' => 'Listar',
            'description' => 'Módulo nieto para listar datos necesarios para editar',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'users/{user}/edit',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 8,
            'name' => 'Listar',
            'description' => 'Módulo nieto para datos necesarios para listar usuarios y permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/users',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 9,
            'name' => 'Listar',
            'description' => 'Módulo nieto para datos necesarios para listar datos para crear permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/users/create',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 10,
            'name' => 'Listar',
            'description' => 'Módulo nieto para interactuar con los permisos del usuario',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/users/{user}',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);
        factory(Module::class)->create([
            'id' => 11,
            'name' => 'Listar',
            'description' => 'Módulo nieto para datos necesarios para editar permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/users/{user}/edit',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);

        //Módulos de API
    }

}
