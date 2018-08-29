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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Module::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
