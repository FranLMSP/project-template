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
            'name' => 'Usuarios',
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
            'name' => 'Usuario',
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
            'name' => 'Datos crear usuario',
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
            'name' => 'Datos editar usuario',
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
            'name' => 'Permisos Usuarios',
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
            'name' => 'Crear Permisos Usuario',
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
            'name' => 'Permisos de usuario',
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
            'name' => 'Datos editar permisos usuario',
            'description' => 'Módulo nieto para datos necesarios para editar permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/users/{user}/edit',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 2,
        ]);

        //Módulos de ROLES

        factory(Module::class)->create([
            'id' => 12,
            'name' => 'Roles',
            'description' => 'Módulo hijo para listar roles',
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => 1,
        ]);

        factory(Module::class)->create([
            'id' => 13,
            'name' => 'Listar',
            'description' => 'Módulo nieto para listar roles',
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/roles',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);

        factory(Module::class)->create([
            'id' => 14,
            'name' => 'Roles',
            'description' => 'Módulo nieto para interactuar roles API',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'roles',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 15,
            'name' => 'Roles',
            'description' => 'Módulo nieto para interactuar roles API',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'roles/{role}',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 16,
            'name' => 'Datos crear rol',
            'description' => 'Módulo nieto para listar datos necesarios para crear',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'roles/create',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 17,
            'name' => 'Datos editar rol',
            'description' => 'Módulo nieto para listar datos necesarios para editar',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'roles/{role}/edit',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 18,
            'name' => 'Permisos roles',
            'description' => 'Módulo nieto para datos necesarios para listar roles y permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/roles',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 19,
            'name' => 'Crear Permisos rol',
            'description' => 'Módulo nieto para datos necesarios para listar datos para crear permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/roles/create',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 20,
            'name' => 'Permisos de rol',
            'description' => 'Módulo nieto para interactuar con los permisos del rol',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/roles/{role}',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);
        factory(Module::class)->create([
            'id' => 21,
            'name' => 'Datos editar permisos rol',
            'description' => 'Módulo nieto para datos necesarios para editar permisos',
            'icon' => 'cog', //Ícono de configuración,
            'url' => 'permissions/roles/{role}/edit',
            'api' => true, //API
            'active' => true,
            'priority' => 0,
            'module_id' => 12,
        ]);

    }

}
