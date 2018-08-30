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

        factory(Module::class)->create([
            'id' => 1,
            'name' => 'Configuración',
            'description' => 'Módulo padre para configuración'
            'icon' => 'cog', //Ícono de configuración,
            'url' => '/',
            'api' => false,
            'active' => true,
            'priority' => 0,
            'module_id' => NULL,
        ]);
    }
}
