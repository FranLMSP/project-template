<?php

use Illuminate\Database\Seeder;

use App\Method;

class MethodsTableSeeder extends Seeder
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

        factory(Method::class)->create([
            'name' => 'GET',
            'description' => 'Obtener',
        ]);
        factory(Method::class)->create([
            'name' => 'POST',
            'description' => 'Crear',
        ]);
        factory(Method::class)->create([
            'name' => 'PUT',
            'description' => 'Modificar',
        ]);
        factory(Method::class)->create([
            'name' => 'DELETE',
            'description' => 'Borrar',
        ]);
    }
}
