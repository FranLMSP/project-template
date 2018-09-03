<?php

use Illuminate\Database\Seeder;
use App\Module;

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

        //Módulos de API
    }
}
